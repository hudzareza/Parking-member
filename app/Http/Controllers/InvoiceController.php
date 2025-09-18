<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Member;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        $query = Invoice::with('member.user','branch');

        // filter berdasarkan role
        if (auth()->user()->hasRole('member')) {
            $query->where('member_id', auth()->user()->member->id);
        } elseif (auth()->user()->hasRole('cabang')) {
            $query->where('branch_id', auth()->user()->branch_id);
        }

        $invoices = $query->get();

        return view('invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        // Authorization: pastikan user hanya bisa lihat yang dia berhak
        if (auth()->user()->hasRole('member') && $invoice->member_id !== auth()->user()->member->id) {
            abort(403);
        }
        if (auth()->user()->hasRole('cabang') && $invoice->branch_id !== auth()->user()->branch_id) {
            abort(403);
        }

        return view('invoices.show', compact('invoice'));
    }

    public function pay(Invoice $invoice)
    {
        if ($invoice->status !== 'unpaid') {
            return back()->with('error', 'Invoice sudah dibayar atau tidak valid.');
        }

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $invoice->code,
                'gross_amount' => $invoice->amount_cents / 100, // convert ke rupiah
            ],
            'customer_details' => [
                'first_name' => $invoice->member->name,
                'email' => $invoice->member->user->email ?? 'noemail@example.com',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('invoices.pay', compact('invoice','snapToken'));
    }

    public function pendingProofs()
    {
        $invoices = Invoice::where('proof_status', 'pending')->with('member')->get();
        return view('invoices.pending', compact('invoices'));
    }

    public function verifyProof(Request $request, Invoice $invoice)
    {
        // $this->authorize('verify-invoice'); // sesuaikan otorisasi

        if ($invoice->status === 'paid') {
            return back()->with('warning', 'Invoice sudah berstatus paid.');
        }

        // Buat record Payment offline (recommended) agar audit trail rapi
        $payment = Payment::create([
            'code' => 'OFF-' . Str::upper(Str::random(8)),
            'member_id' => $invoice->member_id,
            'branch_id' => $invoice->branch_id,
            'gross_amount_cents' => $invoice->amount_cents,
            'status' => 'settlement',
            'midtrans_order_id' => null,
            'midtrans_transaction_id' => null,
            'payment_type' => 'bank_transfer_offline',
            'fraud_status' => null,
            'paid_at' => now(),
            'raw_request' => null,
            'raw_notification' => null,
        ]);

        PaymentItem::create([
            'payment_id' => $payment->id,
            'invoice_id' => $invoice->id,
            'amount_cents' => $invoice->amount_cents,
        ]);

        // update invoice
        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
            'proof_status' => 'accepted',
            'verified_by' => auth()->id(),
            'verification_note' => $request->input('note'),
            'verified_at' => now(),
        ]);

        // optional: buat payment log
        PaymentLog::create([
            'payment_id' => $payment->id,
            'event' => 'manual_verify',
            'message' => 'Admin verified payment manually',
            'payload' => json_encode([
                'admin_id' => auth()->id(),
                'invoice_id' => $invoice->id,
            ]),
        ]);

        return back()->with('success', 'Invoice ' . $invoice->code . ' berhasil diverifikasi dan ditandai LUNAS.');
    }

    public function rejectProof(Request $request, Invoice $invoice)
    {
        // $this->authorize('verify-invoice'); // sesuaikan otorisasi

        $request->validate(['note' => 'nullable|string']);

        $invoice->update([
            'proof_status' => 'rejected',
            'verification_note' => $request->note,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        // (opsional) jangan hapus file agar audit trail ada, atau hapus jika ingin.
        return back()->with('success', 'Bukti transfer ditolak. Beri tahu member untuk upload ulang.');
    }
}

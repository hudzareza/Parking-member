<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Member;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class InvoiceController extends Controller
{
    public function index()
    {
        $query = Invoice::with('member','branch');

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
}

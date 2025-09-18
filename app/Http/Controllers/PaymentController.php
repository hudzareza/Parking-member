<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Midtrans\Notification;
use Midtrans\Config;
use App\Exports\PaymentExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index()
    {
        $query = Payment::with('invoices.member');

        if (auth()->user()->hasRole('member')) {
            $query->whereHas('invoices', fn($q) =>
                $q->where('member_id', auth()->user()->member->id)
            );
        } elseif (auth()->user()->hasRole('cabang')) {
            $query->whereHas('invoices', fn($q) =>
                $q->where('branch_id', auth()->user()->branch_id)
            );
        }

        $payments = $query->get();

        return view('payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $invoice = $payment->invoices->first();

        if (!$invoice) {
            abort(404, 'Invoice tidak ditemukan untuk payment ini.');
        }

        if (auth()->user()->hasRole('member') && $invoice->member_id !== auth()->user()->member->id) {
            abort(403);
        }
        if (auth()->user()->hasRole('cabang') && $invoice->branch_id !== auth()->user()->branch_id) {
            abort(403);
        }

        return view('payments.show', compact('payment'));
    }

    // Endpoint callback dari Midtrans
    public function notificationHandler(Request $request)
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');

        $notif = new Notification();

        $invoice = Invoice::where('code', $notif->order_id)->first();

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        // simpan payment record
        $payment = Payment::updateOrCreate(
            ['midtrans_order_id' => $notif->order_id], // pakai kolom di model Payment
            [
                'code' => 'MT-' . strtoupper(uniqid()),
                'member_id' => $invoice->member_id,
                'branch_id' => $invoice->branch_id,
                'gross_amount_cents' => $notif->gross_amount * 100,
                'status' => $notif->transaction_status,
                'midtrans_order_id' => $notif->order_id,
                'midtrans_transaction_id' => $notif->transaction_id ?? null,
                'payment_type' => $notif->payment_type ?? 'midtrans',
                'fraud_status' => $notif->fraud_status ?? null,
                'paid_at' => $notif->transaction_status === 'settlement' ? now() : null,
                'raw_request' => null,
                'raw_notification' => json_encode($notif),
            ]
        );

        // pastikan ada relasi payment_items
        $payment->items()->updateOrCreate(
            ['invoice_id' => $invoice->id],
            ['amount_cents' => $invoice->amount_cents]
        );

        // update invoice status
        if ($notif->transaction_status === 'settlement') {
            $invoice->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        } elseif ($notif->transaction_status === 'expired') {
            $invoice->update(['status' => 'expired']);
        }

        return response()->json(['message' => 'OK']);
    }

    public function exportExcel()
    {
        return Excel::download(new PaymentExport, 'payments.xlsx');
    }

    public function exportPdf()
    {
        $payments = \App\Models\Payment::all();
        $pdf = Pdf::loadView('exports.payments-pdf', compact('payments'));
        return $pdf->download('payments.pdf');
    }
}

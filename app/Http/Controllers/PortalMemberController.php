<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class PortalMemberController extends Controller
{
    public function show($token)
    {
        $member = Member::where('portal_token', $token)
        ->with(['vehicles.invoices']) // langsung load invoices per kendaraan
        ->firstOrFail();

        $member->load(['vehicles', 'invoices']); // eager load biar tidak N+1 query

        $virtualAccount = config('app.va_static', '1234567890');
        $invoices = $member->invoices()->latest()->get();

        return view('portal.member', compact('member','virtualAccount','invoices'));
    }

    public function uploadProof(Request $request, Invoice $invoice)
    {
        $token = $request->input('token') ?? $request->query('token');

        if (!$token || $invoice->member->portal_token !== $token) {
            abort(403, 'Token tidak valid.');
        }

        $request->validate([
            'proof_file' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($invoice->proof_file) {
            Storage::disk('public')->delete($invoice->proof_file);
        }

        $file = $request->file('proof_file');
        $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('invoices/proofs', $filename, 'public');

        $invoice->update([
            'proof_file' => $path,
            'proof_status' => 'pending',
            'verification_note' => null,
            'verified_by' => null,
            'proof_uploaded_at' => now(),
            'verified_at' => null,
        ]);

        return back()->with('success', 'Bukti transfer berhasil diupload. Menunggu verifikasi admin.');
    }

    public function downloadInvoice(Invoice $invoice, Request $request)
    {
        $token = $request->query('token');

        if (!$token || $invoice->member->portal_token !== $token) {
            abort(403, 'Token tidak valid.');
        }

        $pdf = Pdf::loadView('portal.pdf', compact('invoice'));
        return $pdf->download('Invoice-' . $invoice->code . '.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $query = Invoice::with('member','branch');

        // Filter sesuai role
        if (auth()->user()->hasRole('member')) {
            $query->where('member_id', auth()->user()->member->id);
        } elseif (auth()->user()->hasRole('cabang')) {
            $query->where('branch_id', auth()->user()->branch_id);
        }

        $invoices = $query->paginate(10);

        return view('invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $this->authorize('view', $invoice); // pakai policy
        return view('invoices.show', compact('invoice'));
    }
}


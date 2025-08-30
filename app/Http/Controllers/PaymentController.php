<?php

namespace App\Http\Controllers;

use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $query = Payment::with('invoice.member');

        if (auth()->user()->hasRole('member')) {
            $query->whereHas('invoice', fn($q) =>
                $q->where('member_id', auth()->user()->member->id)
            );
        } elseif (auth()->user()->hasRole('cabang')) {
            $query->whereHas('invoice', fn($q) =>
                $q->where('branch_id', auth()->user()->branch_id)
            );
        }

        $payments = $query->paginate(10);

        return view('payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $this->authorize('view', $payment); // pakai policy
        return view('payments.show', compact('payment'));
    }
}



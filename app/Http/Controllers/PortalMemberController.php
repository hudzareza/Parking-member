<?php

namespace App\Http\Controllers;

use App\Models\Member;

class PortalMemberController extends Controller
{
    public function show($token)
    {
        $member = Member::where('portal_token', $token)
        ->with(['vehicles.invoices']) // langsung load invoices per kendaraan
        ->firstOrFail();
        
        $member->load(['vehicles', 'invoices']); // eager load biar tidak N+1 query

        $virtualAccount = config('app.va_static', '1234567890');

        return view('portal.member', compact('member','virtualAccount'));
    }
}

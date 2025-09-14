<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\MemberExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with(['user', 'branch'])->paginate(10);
        return view('members.index', compact('members'));
    }

    public function create()
    {
        $branches = Branch::all();
        return view('members.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6|confirmed',
            'branch_id'     => 'required|exists:branches,id',
            'phone'         => 'required|string|max:20',
            'id_card_number'=> 'required|string|max:50|unique:members,id_card_number',
        ]);

        // Buat user untuk member
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'branch_id' => $request->branch_id,
        ]);
        $user->assignRole('member');

        // Buat member
        $member = Member::create([
            'user_id'        => $user->id,
            'branch_id'      => $request->branch_id,
            'phone'          => $request->phone,
            'id_card_number' => $request->id_card_number,
            'joined_at'      => now(),
        ]);

        return redirect()->route('members.index')->with('success', 'Member berhasil dibuat.');
    }

    public function show(Member $member)
    {
        $member->load(['user', 'branch', 'vehicles']);
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $branches = Branch::all();
        return view('members.edit', compact('member', 'branches'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $member->user_id,
            'branch_id'     => 'required|exists:branches,id',
            'phone'         => 'required|string|max:20',
            'id_card_number'=> 'required|string|max:50|unique:members,id_card_number,' . $member->id,
        ]);

        // Update user
        $member->user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'branch_id' => $request->branch_id,
        ]);

        // Update member
        $member->update([
            'branch_id'      => $request->branch_id,
            'phone'          => $request->phone,
            'id_card_number' => $request->id_card_number,
        ]);

        return redirect()->route('members.index')->with('success', 'Member berhasil diupdate.');
    }

    public function destroy(Member $member)
    {
        $member->user->delete(); // otomatis delete member karena relasi
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new MemberExport, 'members.xlsx');
    }

    public function exportPdf()
    {
        $members = Member::with(['user','branch','vehicles'])->get();
        $pdf = Pdf::loadView('exports.members-pdf', compact('members'));
        return $pdf->download('members.pdf');
    }
}

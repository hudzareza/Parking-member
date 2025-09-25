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
    public function index(Request $request)
    {
        $query = Member::with(['user', 'branch']);

        // Role filter
        if (auth()->user()->hasRole('cabang')) {
            $query->where('branch_id', auth()->user()->branch_id);
        }
        if (auth()->user()->hasRole('member')) {
            $query->where('user_id', auth()->id());
        }

        // Filter percabang
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        // Filter per bulan & tahun
        if ($request->filled('month')) {
            $query->whereMonth('joined_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('joined_at', $request->year);
        }

        // Filter per tanggal (range)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('joined_at', [$request->start_date, $request->end_date]);
        }

        $members = $query->get();
        $branches = \App\Models\Branch::all();

        return view('members.index', compact('members', 'branches'));
    }


    public function create()
    {
        $query = Branch::query();

        if (auth()->user()->hasRole('cabang')) {
            // hanya lihat branch miliknya
            $query->where('id', auth()->user()->branch_id);
        }

        $branches = $query->get();
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
            'id_card_number' => '-',
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
        $query = Branch::query();

        if (auth()->user()->hasRole('cabang')) {
            // hanya lihat branch miliknya
            $query->where('id', auth()->user()->branch_id);
        }

        $branches = $query->get();
        return view('members.edit', compact('member', 'branches'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $member->user_id,
            'branch_id'     => 'required|exists:branches,id',
            'phone'         => 'required|string|max:20',
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
            'id_card_number' => "-",
        ]);

        return redirect()->route('members.index')->with('success', 'Member berhasil diupdate.');
    }

    public function destroy(Member $member)
    {
        // Cek apakah member punya invoice
        if ($member->invoices()->count() > 0) {
            $member->invoices()->delete();
        }

        // Hapus kendaraan terkait
        if ($member->vehicles()->count() > 0) {
            $member->vehicles()->delete();
        }

        // Hapus member
        $member->delete();

        // Hapus user terkait
        if ($member->user) {
            $member->user->delete();
        }

        return redirect()->route('members.index')->with('success', 'Member beserta data terkait berhasil dihapus.');
    }


    public function exportExcel(Request $request)
    {
        $filters = $request->only(['branch_id','month','year','start_date','end_date']);
        return Excel::download(new MemberExport($filters), 'members.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Member::with(['user','branch','vehicles']);

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        if ($request->filled('month')) {
            $query->whereMonth('joined_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('joined_at', $request->year);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('joined_at', [$request->start_date, $request->end_date]);
        }

        $members = $query->get();

        $pdf = Pdf::loadView('exports.members-pdf', compact('members'));
        return $pdf->download('members.pdf');
    }
}

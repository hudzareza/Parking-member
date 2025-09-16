<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exports\BranchesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class BranchController extends Controller
{
    // public function __construct()
    // {
    //     // Pastikan hanya role dengan permission bisa akses
    //     $this->middleware('permission:manage branches');
    // }

    public function index()
    {
        $branches = Branch::all();
        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        return view('branches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string',
        ]);

        Branch::create([
            'name' => $request->name,
            'address' => $request->address,
            'code' => 'CBG-' . strtoupper(Str::random(5)), 
        ]);

        return redirect()->route('branches.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Branch $branch)
    {
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string',
            'code' => 'nullable|string',
        ]);

        $branch->update($request->only(['name', 'address', 'code']));

        return redirect()->route('branches.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Lokasi berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new BranchesExport, 'lokasi.xlsx');
    }

    public function exportPdf()
    {
        $branches = \App\Models\Branch::all();
        $pdf = Pdf::loadView('exports.branches-pdf', compact('branches'));
        return $pdf->download('lokasi.pdf');
    }
}

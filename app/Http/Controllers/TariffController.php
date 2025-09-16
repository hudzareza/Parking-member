<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Exports\TariffExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TariffController extends Controller
{
    public function index()
    {
        $tariffs = Tariff::with('branch')->orderBy('effective_start', 'desc')->get();
        return view('tariffs.index', compact('tariffs'));
    }

    public function create()
    {
        $branches = Branch::pluck('name', 'id');
        return view('tariffs.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch_id'       => 'nullable|exists:branches,id',
            'vehicle_type'    => 'required|in:motor,mobil',
            'amount_cents'    => 'required|integer|min:0',
            'effective_start' => 'required|date',
        ]);

        Tariff::create($request->all());

        return redirect()->route('tariffs.index')->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function show(Tariff $tariff)
    {
        return view('tariffs.show', compact('tariff'));
    }

    public function edit(Tariff $tariff)
    {
        $branches = Branch::pluck('name', 'id');
        return view('tariffs.edit', compact('tariff','branches'));
    }

    public function update(Request $request, Tariff $tariff)
    {
        $user = auth()->user();

        // Jika role = cabang, cek apakah tarif miliknya
        if ($user->hasRole('cabang') && $tariff->branch_id !== $user->branch_id) {
            abort(403, 'Anda tidak boleh mengedit tarif lokasi lain.');
        }

        $request->validate([
            'branch_id'       => 'nullable|exists:branches,id',
            'vehicle_type'    => 'required|in:motor,mobil',
            'amount_cents'    => 'required|integer|min:0',
            'effective_start' => 'required|date',
        ]);

        $tariff->update($request->all());

        return redirect()->route('tariffs.index')->with('success', 'Tarif berhasil diupdate.');
    }

    public function destroy(Tariff $tariff)
    {
        $tariff->delete();

        return redirect()->route('tariffs.index')->with('success', 'Tarif berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new TariffExport, 'tariffs.xlsx');
    }

    public function exportPdf()
    {
        $tariffs = Tariff::with('branch')->orderBy('effective_start', 'desc')->get();
        $pdf = Pdf::loadView('exports.tariffs-pdf', compact('tariffs'));
        return $pdf->download('tariffs.pdf');
    }
}

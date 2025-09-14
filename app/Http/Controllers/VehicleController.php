<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Exports\VehicleExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class VehicleController extends Controller
{
    public function index(Member $member)
    {
        $vehicles = $member->vehicles()->paginate(10);
        return view('vehicles.index', compact('member', 'vehicles'));
    }

    public function create(Member $member)
    {
        return view('vehicles.create', compact('member'));
    }

    public function store(Request $request, Member $member)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
            'vehicle_type' => 'required|in:motor,mobil',
            'brand'        => 'nullable|string|max:100',
            'model'        => 'nullable|string|max:100',
        ]);

        $member->vehicles()->create($request->only(['plate_number','vehicle_type','brand','model']));

        return redirect()->route('members.vehicles.index', $member)
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function show(Member $member, Vehicle $vehicle)
    {
        return view('vehicles.show', compact('member','vehicle'));
    }

    public function edit(Member $member, Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('member','vehicle'));
    }

    public function update(Request $request, Member $member, Vehicle $vehicle)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'vehicle_type' => 'required|in:motor,mobil',
            'brand'        => 'nullable|string|max:100',
            'model'        => 'nullable|string|max:100',
        ]);

        $vehicle->update($request->only(['plate_number','vehicle_type','brand','model']));

        return redirect()->route('members.vehicles.index', $member)
            ->with('success', 'Kendaraan berhasil diupdate.');
    }

    public function destroy(Member $member, Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('members.vehicles.index', $member)
            ->with('success', 'Kendaraan berhasil dihapus.');
    }

    public function listPerBranch(Request $request)
    {
        $branches = \App\Models\Branch::all();

        $query = \App\Models\Vehicle::with(['member.branch', 'member.user']);

        if ($request->branch_id) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('branch_id', $request->branch_id);
            });
        }

        $vehicles = $query->paginate(10);

        return view('vehicles.list-per-branch', compact('vehicles', 'branches'));
    }

    public function exportExcel(Request $request)
    {
        $branchId = $request->branch_id ?? null;
        return Excel::download(new VehicleExport($branchId), 'vehicles.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = \App\Models\Vehicle::with(['member.branch','member.user']);

        if ($request->branch_id) {
            $query->whereHas('member', function ($q) use ($request) {
                $q->where('branch_id', $request->branch_id);
            });
        }

        $vehicles = $query->get();

        $pdf = Pdf::loadView('exports.vehicles-pdf', compact('vehicles'));
        return $pdf->download('vehicles.pdf');
    }
}

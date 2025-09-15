<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use App\Models\Invoice;
use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SelfServiceController extends Controller
{
    public function showForm()
    {
        $branches = \App\Models\Branch::all();
        return view('selfservice.form', compact('branches'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'mode'                   => 'required|in:new,renew',
            'branch_id'              => 'required|exists:branches,id',
            'name'                   => 'required_if:mode,new|string|max:255',
            'email'                  => 'nullable|email',
            'phone'                  => 'required',
            // 'id_card_number'         => 'nullable|string',
            'vehicles'               => 'required|array|min:1',
            'vehicles.*.vehicle_type'=> 'required|in:motor,mobil',
            'vehicles.*.plate_number'=> 'required|string',
        ]);

        if ($request->mode === 'new') {
            // 1. Buat user
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email ?? Str::random(8).'@example.com',
                'password'  => Hash::make(Str::random(12)),
                'branch_id' => $request->branch_id,
            ]);
            $user->assignRole('member');

            // 2. Buat member
            $member = Member::create([
                'user_id'        => $user->id,
                'branch_id'      => $request->branch_id,
                'phone'          => $request->phone,
                'id_card_number' => '-',
                // 'id_card_number' => $request->id_card_number,
                'joined_at'      => now(),
            ]);

            // 3. Simpan kendaraan + invoice per kendaraan
            foreach ($request->vehicles as $veh) {
                $vehicle = $member->vehicles()->create([
                    'vehicle_type' => $veh['vehicle_type'],
                    'plate_number' => $veh['plate_number'],
                ]);

                $tariff = Tariff::activeFor($request->branch_id, $veh['vehicle_type'])->first();
                if ($tariff) {
                    Invoice::firstOrCreate(
                        [
                            'member_id'  => $member->id,
                            'vehicle_id' => $vehicle->id,
                            'period'     => now()->startOfMonth(),
                        ],
                        [
                            'code'        => 'INV-' . strtoupper(Str::random(8)),
                            'branch_id'   => $request->branch_id,
                            'amount_cents'=> $tariff->amount_cents,
                            'due_date'    => now()->addDays(7),
                            'status'      => 'unpaid',
                        ]
                    );
                }
            }

            return redirect()->route('portal.member', ['token' => $member->portal_token])
                ->with('success', 'Pendaftaran berhasil, silakan lakukan pembayaran.');
        }

        if ($request->mode === 'renew') {
            $member = Member::where('phone', $request->phone)->firstOrFail();

            // Tambah kendaraan kalau ada input baru
            foreach ($request->vehicles as $veh) {
                $vehicle = $member->vehicles()->firstOrCreate(
                    ['plate_number' => $veh['plate_number']],
                    ['vehicle_type' => $veh['vehicle_type']]
                );

                $tariff = Tariff::activeFor($member->branch_id, $vehicle->vehicle_type)->first();
                if ($tariff) {
                    Invoice::firstOrCreate(
                        [
                            'member_id'  => $member->id,
                            'vehicle_id' => $vehicle->id,
                            'period'     => now()->startOfMonth(),
                        ],
                        [
                            'code'        => 'INV-' . strtoupper(Str::random(8)),
                            'branch_id'   => $member->branch_id,
                            'amount_cents'=> $tariff->amount_cents,
                            'due_date'    => now()->addDays(7),
                            'status'      => 'unpaid',
                        ]
                    );
                }
            }

            return redirect()->route('portal.member', ['token' => $member->portal_token])
                ->with('success', 'Silakan lanjut ke pembayaran perpanjangan.');
        }
    }

    public function processRenew(Request $request)
    {
        $request->validate([
            'identifier'               => 'required|string',
            'vehicles'                 => 'nullable|array',
            'vehicles.*.vehicle_type'  => 'required_with:vehicles|in:motor,mobil',
            'vehicles.*.plate_number'  => 'required_with:vehicles|string',
        ]);

        // cari member lewat email atau no hp
        $member = Member::whereHas('user', function($q) use ($request) {
                        $q->where('email', $request->identifier);
                    })
                    ->orWhere('phone', $request->identifier)
                    ->first();

        if (!$member) {
            return back()->with('error', 'Member tidak ditemukan. Silakan daftar baru.');
        }

        // Tambah kendaraan kalau ada input baru
        if ($request->has('vehicles')) {
            foreach ($request->vehicles as $veh) {
                $vehicle = $member->vehicles()->firstOrCreate(
                    ['plate_number' => $veh['plate_number']],
                    ['vehicle_type' => $veh['vehicle_type']]
                );

                $tariff = Tariff::activeFor($member->branch_id, $vehicle->vehicle_type)->first();
                if ($tariff) {
                    Invoice::firstOrCreate(
                        [
                            'member_id'  => $member->id,
                            'vehicle_id' => $vehicle->id,
                            'period'     => now()->startOfMonth(),
                        ],
                        [
                            'code'        => 'INV-' . strtoupper(Str::random(8)),
                            'branch_id'   => $member->branch_id,
                            'amount_cents'=> $tariff->amount_cents,
                            'due_date'    => now()->addDays(7),
                            'status'      => 'unpaid',
                        ]
                    );
                }
            }
        }

        return redirect()->route('portal.member', ['token' => $member->portal_token])
            ->with('success', 'Silakan lanjut ke pembayaran perpanjangan.');
    }
}

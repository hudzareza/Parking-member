<?php

namespace App\Services;

use App\Models\{Member, Tariff, Invoice};
use Illuminate\Support\Str;
use Carbon\Carbon;

class InvoiceService
{
    public function generateForPeriod(int $year, int $month)
    {
        $period = Carbon::create($year, $month, 1);
        $dueDate = $period->copy()->addDays(7);

        $members = Member::with(['vehicles', 'branch'])->get();

        foreach ($members as $member) {
            // skip jika sudah ada invoice bulan itu
            if (Invoice::where('member_id', $member->id)
                ->where('period', $period->toDateString())
                ->exists()) {
                continue;
            }

            $total = 0;

            foreach ($member->vehicles as $vehicle) {
                $tariff = Tariff::where(function ($q) use ($member) {
                        $q->whereNull('branch_id')
                          ->orWhere('branch_id', $member->branch_id);
                    })
                    ->where('vehicle_type', $vehicle->vehicle_type)
                    ->where('effective_start', '<=', $period)
                    ->orderByDesc('effective_start')
                    ->first();

                if ($tariff) {
                    $total += $tariff->amount_cents;
                }
            }

            if ($total === 0) {
                continue; // tidak ada tarif aktif
            }

            Invoice::create([
                'code'        => $this->generateInvoiceCode($period),
                'member_id'   => $member->id,
                'branch_id'   => $member->branch_id,
                'period'      => $period,
                'amount_cents'=> $total,
                'status'      => 'unpaid',
                'due_date'    => $dueDate,
            ]);
        }
    }

    protected function generateInvoiceCode(Carbon $period): string
    {
        $prefix = 'INV-' . $period->format('Ym');
        $last = Invoice::where('code', 'like', $prefix.'%')
            ->orderByDesc('id')
            ->first();

        $seq = $last ? intval(substr($last->code, -4)) + 1 : 1;

        return $prefix . '-' . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}

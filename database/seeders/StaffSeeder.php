<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Role;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $roles = collect([
            ['name' => 'Innkeeper', 'slug' => 'innkeeper', 'department' => 'Management', 'base_hourly_rate' => 18],
            ['name' => 'Head Chef', 'slug' => 'head-chef', 'department' => 'Kitchen', 'base_hourly_rate' => 17],
            ['name' => 'Server', 'slug' => 'server', 'department' => 'Service', 'base_hourly_rate' => 12],
            ['name' => 'Bartender', 'slug' => 'bartender', 'department' => 'Bar', 'base_hourly_rate' => 14],
            ['name' => 'Host', 'slug' => 'host', 'department' => 'Service', 'base_hourly_rate' => 11],
        ])->mapWithKeys(fn($r) => [$r['slug'] => Role::create($r)]);

        $employees = [
            [
                'role_id' => $roles['innkeeper']->id,
                'first_name' => 'Sir',
                'last_name' => 'Aldric',
                'email' => 'aldric@servora.example',
                'phone' => '+1 555 0142',
                'department' => 'Management',
                'avatar_color' => 'green',
                'joined_at' => Carbon::now()->subMonths(18)->toDateString(),
            ],
            [
                'role_id' => $roles['head-chef']->id,
                'first_name' => 'Mira',
                'last_name' => 'Vane',
                'email' => 'mira@servora.example',
                'phone' => '+1 555 0231',
                'department' => 'Kitchen',
                'avatar_color' => 'tan',
                'joined_at' => Carbon::now()->subMonths(12)->toDateString(),
            ],
            [
                'role_id' => $roles['server']->id,
                'first_name' => 'Elira',
                'last_name' => 'Windmere',
                'email' => 'elira@servora.example',
                'phone' => '+1 555 0388',
                'department' => 'Service',
                'avatar_color' => 'green',
                'joined_at' => Carbon::now()->subMonths(6)->toDateString(),
            ],
            [
                'role_id' => $roles['bartender']->id,
                'first_name' => 'Captain',
                'last_name' => 'Orin',
                'email' => 'orin@servora.example',
                'phone' => '+1 555 0455',
                'department' => 'Bar',
                'avatar_color' => 'amber',
                'joined_at' => Carbon::now()->subMonths(3)->toDateString(),
            ],
            [
                'role_id' => $roles['host']->id,
                'first_name' => 'Lady',
                'last_name' => 'Wren',
                'email' => 'wren@servora.example',
                'phone' => '+1 555 0511',
                'department' => 'Service',
                'avatar_color' => 'gray',
                'joined_at' => Carbon::now()->subMonth()->toDateString(),
            ],
        ];

        $employees = collect($employees)->map(fn($data) => Employee::create($data + ['status' => 'active']));

        $today = Carbon::today();

        // Today's shifts — Aldric, Mira, Elira, Orin, Wren
        $shiftData = [
            [$employees[0], 'Morning Service', '08:00', '16:30', 'working'],
            [$employees[1], 'Morning Service', '08:00', '15:48', 'working'],
            [$employees[2], 'Mid Shift', '10:00', '15:30', 'completed'],
            [$employees[3], 'Evening Service', '17:00', '01:00', 'scheduled'],
            [$employees[4], 'Morning Host', '08:00', '12:00', 'completed'],
        ];

        foreach ($shiftData as [$emp, $name, $start, $end, $status]) {
            $shift = Shift::create([
                'employee_id' => $emp->id,
                'name' => $name,
                'shift_date' => $today,
                'start_time' => $start,
                'end_time' => $end,
                'status' => $status,
            ]);

            if ($status === 'completed' || $status === 'working') {
                Attendance::create([
                    'employee_id' => $emp->id,
                    'shift_id' => $shift->id,
                    'date' => $today,
                    'clocked_in_at' => $today->copy()->setTimeFromTimeString($start)->addMinutes(7),
                    'clocked_out_at' => $status === 'completed'
                        ? $today->copy()->setTimeFromTimeString($end)
                        : null,
                    'hours_worked' => $shift->duration_hours,
                    'status' => 'present',
                ]);
            }
        }

        // Seed some pending payroll so the "Pending Payroll" card shows real numbers
        $pendingTotal = 8420;
        $perEmployee = $pendingTotal / $employees->count();

        foreach ($employees as $emp) {
            Payroll::create([
                'employee_id' => $emp->id,
                'period_start' => Carbon::now()->startOfMonth()->toDateString(),
                'period_end' => Carbon::now()->endOfMonth()->toDateString(),
                'hours_worked' => 80,
                'amount' => round($perEmployee, 2),
                'currency' => 'silver',
                'status' => 'pending',
            ]);
        }
    }
}
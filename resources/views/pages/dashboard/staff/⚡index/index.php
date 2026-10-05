<?php

use Livewire\Component;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Role;
use App\Models\Shift;
use Carbon\Carbon;


new class extends Component {
    public string $view = 'Employees';
    public string $search = '';
    public string $selectedRole = 'All Roles';
    public ?int $selectedEmployee = null;

    // ---- Employee modal ----
    public bool $showEmployeeModal = false;
    public array $employeeForm = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'phone' => '',
        'department' => 'Service',
        'role_id' => null,
        'avatar_color' => 'green',
    ];

    // ---- Shift modal ----
    public bool $showShiftModal = false;
    public array $shiftForm = [
        'employee_id' => null,
        'name' => 'Morning Service',
        'shift_date' => '',
        'start_time' => '08:00',
        'end_time' => '16:30',
        'status' => 'scheduled',
    ];

    // ---- Shift tab filters ----
    public string $shiftFilterStatus = 'all';
    public ?string $shiftFilterFrom = null;
    public ?string $shiftFilterTo = null;
    public ?int $shiftFilterEmployee = null;

    // ---- Attendance tab filters ----
    public string $attendanceFilterStatus = 'all';
    public ?string $attendanceFilterFrom = null;
    public ?string $attendanceFilterTo = null;
    public ?int $attendanceFilterEmployee = null;

    // ---- Payroll tab filters ----
    public string $payrollFilterStatus = 'all';
    public ?string $payrollFilterFrom = null;
    public ?string $payrollFilterTo = null;
    public ?int $payrollFilterEmployee = null;

    // ---- Roles tab filters + modal ----
    public string $roleFilterDepartment = 'all';
    public string $roleSearch = '';
    public bool $showRoleModal = false;
    public ?int $editingRoleId = null;
    public array $roleForm = [
        'name' => '',
        'slug' => '',
        'department' => 'Service',
        'description' => '',
        'base_hourly_rate' => 0,
    ];

    public function mount(): void
    {
        $this->shiftForm['shift_date'] = now()->toDateString();
        $this->selectedEmployee = Employee::query()->orderBy('first_name')->value('id');

        // Default tab filters
        $this->shiftFilterFrom = now()->startOfWeek()->toDateString();
        $this->shiftFilterTo = now()->endOfWeek()->toDateString();

        $this->attendanceFilterFrom = now()->startOfMonth()->toDateString();
        $this->attendanceFilterTo = now()->endOfMonth()->toDateString();

        $this->payrollFilterFrom = now()->startOfMonth()->toDateString();
        $this->payrollFilterTo = now()->endOfMonth()->toDateString();
    }

    // ---------------------------------------------------------------------
    // Navigation
    // ---------------------------------------------------------------------

    public function setView(string $view): void
    {
        $this->view = $view;
    }

    public function setRole(string $role): void
    {
        $this->selectedRole = $role;
    }

    public function selectEmployee(int $id): void
    {
        $this->selectedEmployee = $id;
    }

    // ---------------------------------------------------------------------
    // Employee actions
    // ---------------------------------------------------------------------

    public function addEmployee(): void
    {
        $this->resetValidation();
        $this->employeeForm = [
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'phone' => '',
            'department' => 'Service',
            'role_id' => Role::query()->orderBy('name')->value('id'),
            'avatar_color' => 'green',
        ];
        $this->showEmployeeModal = true;
    }

    public function saveEmployee(): void
    {
        $data = $this->validate([
            'employeeForm.first_name' => 'required|string|max:100',
            'employeeForm.last_name' => 'required|string|max:100',
            'employeeForm.email' => 'required|email|max:255|unique:employees,email',
            'employeeForm.phone' => 'nullable|string|max:50',
            'employeeForm.department' => 'required|in:Management,Kitchen,Service,Bar,Support',
            'employeeForm.role_id' => 'nullable|exists:roles,id',
            'employeeForm.avatar_color' => 'required|in:green,tan,amber,gray',
        ])['employeeForm'];

        $data['joined_at'] = now()->toDateString();
        $data['status'] = 'active';

        $employee = Employee::create($data);

        $this->showEmployeeModal = false;
        $this->selectedEmployee = $employee->id;
    }

    // ---------------------------------------------------------------------
    // Shift actions
    // ---------------------------------------------------------------------

    public function createShift(): void
    {
        $this->resetValidation();
        $this->shiftForm = [
            'employee_id' => $this->selectedEmployee ?? Employee::query()->value('id'),
            'name' => 'Morning Service',
            'shift_date' => now()->toDateString(),
            'start_time' => '08:00',
            'end_time' => '16:30',
            'status' => 'scheduled',
        ];
        $this->showShiftModal = true;
    }

    public function saveShift(): void
    {
        $data = $this->validate([
            'shiftForm.employee_id' => 'required|exists:employees,id',
            'shiftForm.name' => 'required|string|max:100',
            'shiftForm.shift_date' => 'required|date',
            'shiftForm.start_time' => 'required|date_format:H:i',
            'shiftForm.end_time' => 'required|date_format:H:i',
            'shiftForm.status' => 'required|in:scheduled,working,completed,missed',
        ])['shiftForm'];

        Shift::create($data);
        $this->showShiftModal = false;
    }

    public function deleteShift(int $id): void
    {
        Shift::query()->whereKey($id)->delete();
    }

    public function updateShiftStatus(int $id, string $status): void
    {
        if (!in_array($status, ['scheduled', 'working', 'completed', 'missed'], true)) {
            return;
        }

        Shift::query()->whereKey($id)->update(['status' => $status]);
    }

    // ---------------------------------------------------------------------
    // Attendance actions
    // ---------------------------------------------------------------------

    public function clockIn(int $employeeId): void
    {
        $today = Carbon::today();

        Attendance::query()->create([
            'employee_id' => $employeeId,
            'date' => $today,
            'clocked_in_at' => now(),
            'status' => 'present',
        ]);
    }

    public function clockOut(int $attendanceId): void
    {
        $attendance = Attendance::query()->find($attendanceId);
        if (!$attendance || $attendance->clocked_out_at) {
            return;
        }

        $clockedOut = now();
        $hours = $attendance->clocked_in_at
            ? round($attendance->clocked_in_at->diffInMinutes($clockedOut) / 60, 2)
            : 0;

        $attendance->update([
            'clocked_out_at' => $clockedOut,
            'hours_worked' => $hours,
        ]);
    }

    // ---------------------------------------------------------------------
    // Payroll actions
    // ---------------------------------------------------------------------

    public function markPayrollPaid(int $id): void
    {
        Payroll::query()->whereKey($id)->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    public function cancelPayroll(int $id): void
    {
        Payroll::query()->whereKey($id)->update(['status' => 'cancelled']);
    }

    // ---------------------------------------------------------------------
    // Role actions
    // ---------------------------------------------------------------------

    public function addRole(): void
    {
        $this->resetValidation();
        $this->editingRoleId = null;
        $this->roleForm = [
            'name' => '',
            'slug' => '',
            'department' => 'Service',
            'description' => '',
            'base_hourly_rate' => 0,
        ];
        $this->showRoleModal = true;
    }

    public function editRole(int $id): void
    {
        $role = Role::query()->findOrFail($id);

        $this->editingRoleId = $role->id;
        $this->roleForm = [
            'name' => $role->name,
            'slug' => $role->slug,
            'department' => $role->department,
            'description' => $role->description ?? '',
            'base_hourly_rate' => (float) $role->base_hourly_rate,
        ];
        $this->showRoleModal = true;
    }

    public function saveRole(): void
    {
        $rules = [
            'roleForm.name' => 'required|string|max:100',
            'roleForm.slug' => 'required|string|max:100|unique:roles,slug',
            'roleForm.department' => 'required|in:Management,Kitchen,Service,Bar,Support',
            'roleForm.description' => 'nullable|string|max:500',
            'roleForm.base_hourly_rate' => 'required|numeric|min:0|max:9999',
        ];

        if ($this->editingRoleId) {
            $rules['roleForm.slug'] = 'required|string|max:100|unique:roles,slug,' . $this->editingRoleId;
        }

        $data = $this->validate($rules)['roleForm'];

        if ($this->editingRoleId) {
            Role::query()->whereKey($this->editingRoleId)->update($data);
        } else {
            Role::query()->create($data);
        }

        $this->showRoleModal = false;
        $this->editingRoleId = null;
    }

    public function deleteRole(int $id): void
    {
        // Nullify employees referencing this role first
        Employee::query()->where('role_id', $id)->update(['role_id' => null]);
        Role::query()->whereKey($id)->delete();
    }

    // ---------------------------------------------------------------------
    // Stats
    // ---------------------------------------------------------------------

    /** @return array<string, mixed> */
    protected function stats(): array
    {
        $today = Carbon::today();
        $periodStart = now()->startOfMonth();
        $periodEnd = now()->endOfMonth();

        $activeStaff = Employee::query()->where('status', 'active')->count();

        $scheduledToday = Shift::query()
            ->whereDate('shift_date', $today)
            ->distinct()
            ->count('employee_id');

        $workingNow = Shift::query()
            ->whereDate('shift_date', $today)
            ->where('status', 'working')
            ->count();

        $totalAttendance = Attendance::query()
            ->whereBetween('date', [$periodStart, $periodEnd])
            ->count();

        $present = Attendance::query()
            ->whereBetween('date', [$periodStart, $periodEnd])
            ->whereIn('status', ['present', 'late'])
            ->count();

        $attendancePercent = $totalAttendance > 0
            ? (int) round(($present / $totalAttendance) * 100)
            : 100;

        $pendingPayroll = (float) Payroll::query()
            ->where('status', 'pending')
            ->sum('amount');

        return [
            'active_staff' => $activeStaff,
            'scheduled_today' => $scheduledToday,
            'working_now' => $workingNow,
            'attendance_percent' => $attendancePercent,
            'pending_payroll' => $pendingPayroll,
        ];
    }

    // ---------------------------------------------------------------------
    // Render
    // ---------------------------------------------------------------------

    public function render()
    {
        $today = Carbon::today();

        $employees = Employee::query()
            ->with([
                'role',
                'shifts' => fn($q) => $q->whereDate('shift_date', $today)->orderBy('start_time'),
                'attendances' => fn($q) => $q->whereDate('date', $today)->latest('clocked_in_at'),
            ])
            ->when($this->search !== '', function ($q) {
                $term = '%' . $this->search . '%';
                $q->where(function ($q) use ($term) {
                    $q->where('first_name', 'like', $term)
                        ->orWhere('last_name', 'like', $term)
                        ->orWhere('email', 'like', $term);
                });
            })
            ->when($this->selectedRole !== 'All Roles', fn($q) => $q->where('department', $this->selectedRole))
            ->orderBy('first_name')
            ->get();

        $selectedEmployeeModel = $this->selectedEmployee
            ? Employee::query()
                ->with([
                    'role',
                    'shifts' => fn($q) => $q->whereDate('shift_date', $today)->orderBy('start_time'),
                    'attendances' => fn($q) => $q->whereDate('date', $today)->latest('clocked_in_at'),
                ])
                ->find($this->selectedEmployee)
            : null;

        // ---- Tab data ----
        $shifts = $this->shiftsQuery()->paginate(15, ['*'], 'shiftsPage');
        $attendance = $this->attendanceQuery()->paginate(15, ['*'], 'attendancePage');
        $payroll = $this->payrollQuery()->paginate(15, ['*'], 'payrollPage');

        $roles = Role::query()
            ->withCount('employees')
            ->when($this->roleFilterDepartment !== 'all', fn($q) => $q->where('department', $this->roleFilterDepartment))
            ->when($this->roleSearch !== '', function ($q) {
                $term = '%' . $this->roleSearch . '%';
                $q->where(fn($q) => $q->where('name', 'like', $term)->orWhere('slug', 'like', $term));
            })
            ->orderBy('name')
            ->get();

        return $this->view([
            'employees' => $employees,
            'selectedEmployeeModel' => $selectedEmployeeModel,
            'roles' => Role::query()->orderBy('name')->get(),
            'roleList' => $roles,
            'shifts' => $shifts,
            'attendance' => $attendance,
            'payroll' => $payroll,
            'stats' => $this->stats(),
            'roleFilters' => ['All Roles', 'Management', 'Kitchen', 'Service', 'Bar', 'Support'],
            'departments' => ['Management', 'Kitchen', 'Service', 'Bar', 'Support'],
            'shiftStatuses' => ['scheduled', 'working', 'completed', 'missed'],
            'attendanceStatuses' => ['present', 'late', 'absent', 'leave'],
            'payrollStatuses' => ['pending', 'paid', 'cancelled'],
            'allEmployees' => Employee::query()->orderBy('first_name')->get(),
        ]);
    }

    protected function shiftsQuery()
    {
        return Shift::query()
            ->with('employee.role')
            ->when($this->shiftFilterEmployee, fn($q) => $q->where('employee_id', $this->shiftFilterEmployee))
            ->when($this->shiftFilterStatus !== 'all', fn($q) => $q->where('status', $this->shiftFilterStatus))
            ->when($this->shiftFilterFrom, fn($q) => $q->whereDate('shift_date', '>=', $this->shiftFilterFrom))
            ->when($this->shiftFilterTo, fn($q) => $q->whereDate('shift_date', '<=', $this->shiftFilterTo))
            ->orderByDesc('shift_date')
            ->orderBy('start_time');
    }

    protected function attendanceQuery()
    {
        return Attendance::query()
            ->with(['employee.role', 'shift'])
            ->when($this->attendanceFilterEmployee, fn($q) => $q->where('employee_id', $this->attendanceFilterEmployee))
            ->when($this->attendanceFilterStatus !== 'all', fn($q) => $q->where('status', $this->attendanceFilterStatus))
            ->when($this->attendanceFilterFrom, fn($q) => $q->whereDate('date', '>=', $this->attendanceFilterFrom))
            ->when($this->attendanceFilterTo, fn($q) => $q->whereDate('date', '<=', $this->attendanceFilterTo))
            ->orderByDesc('date')
            ->orderByDesc('clocked_in_at');
    }

    protected function payrollQuery()
    {
        return Payroll::query()
            ->with('employee.role')
            ->when($this->payrollFilterEmployee, fn($q) => $q->where('employee_id', $this->payrollFilterEmployee))
            ->when($this->payrollFilterStatus !== 'all', fn($q) => $q->where('status', $this->payrollFilterStatus))
            ->when($this->payrollFilterFrom, fn($q) => $q->whereDate('period_start', '>=', $this->payrollFilterFrom))
            ->when($this->payrollFilterTo, fn($q) => $q->whereDate('period_end', '<=', $this->payrollFilterTo))
            ->orderByDesc('period_start');
    }
};
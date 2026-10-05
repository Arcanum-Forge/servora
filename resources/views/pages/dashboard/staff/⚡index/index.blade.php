<div class="min-h-full space-y-8 pb-12">

    {{-- ================================================================
        PAGE HEADER
    ================================================================= --}}
    <div class="relative overflow-hidden rounded-[2rem] border border-[#DCE5DC] bg-[#F4F7F1]">

        {{-- Decorative background --}}
        <div class="pointer-events-none absolute -right-24 -top-32 h-80 w-80 rounded-full bg-[#DDE9D9] blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-32 left-1/3 h-64 w-64 rounded-full bg-[#EAE8D8] blur-3xl"></div>

        <div class="relative p-6 sm:p-8 lg:p-10">

            <div class="flex flex-col gap-8 xl:flex-row xl:items-end xl:justify-between">

                <div>
                    <div class="mb-5 flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.16em] text-[#829087]">
                        <span>Operations</span>
                        <span class="text-[#B1BBB4]">/</span>
                        <span class="text-[#294936]">Staff</span>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="hidden h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#294936] text-white shadow-lg shadow-[#294936]/10 sm:flex">
                            <x-tabler-users-group class="h-7 w-7" />
                        </div>

                        <div>
                            <h1 class="text-3xl font-semibold tracking-[-0.03em] text-[#26342A] sm:text-4xl">
                                Your people.
                            </h1>

                            <p class="mt-2 max-w-xl text-sm leading-6 text-[#718076] sm:text-base">
                                Keep your team scheduled, accounted for, and paid.
                                Everything happening with your staff, in one place.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">

                    <button type="button"
                        wire:click="createShift"
                        class="group inline-flex items-center gap-2 rounded-2xl border border-[#CBD8CC] bg-white/80 px-4 py-3 text-sm font-semibold text-[#294936] shadow-sm transition hover:-translate-y-0.5 hover:bg-white hover:shadow-md">
                        <x-tabler-calendar-plus class="h-4 w-4 transition group-hover:scale-110" />
                        Schedule shift
                    </button>

                    <button type="button"
                        wire:click="addEmployee"
                        class="group inline-flex items-center gap-2 rounded-2xl bg-[#294936] px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-[#294936]/15 transition hover:-translate-y-0.5 hover:bg-[#183524] hover:shadow-xl">
                        <x-tabler-user-plus class="h-4 w-4 transition group-hover:scale-110" />
                        Add employee
                    </button>

                </div>
            </div>

            {{-- Live status --}}
            <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-3 border-t border-[#D8E2D8] pt-5">

                <div class="flex items-center gap-2 text-xs font-medium text-[#718076]">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#6C9274] opacity-60"></span>
                        <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-[#5E8067]"></span>
                    </span>
                    Staff operations live
                </div>

                <div class="h-3 w-px bg-[#CCD7CE]"></div>

                <p class="text-xs text-[#829087]">
                    {{ now()->format('l, j F Y') }}
                </p>

            </div>
        </div>
    </div>


    {{-- ================================================================
        NAVIGATION
    ================================================================= --}}
    <div class="sticky top-0 z-20 -mx-2 px-2 py-2 backdrop-blur-xl">

        <div class="flex overflow-x-auto rounded-2xl border border-[#DCE5DC] bg-white/90 p-1.5 shadow-sm">

            @php
                $navigation = [
                    ['Employees', 'users'],
                    ['Roles', 'badge'],
                    ['Shifts', 'calendar-event'],
                    ['Attendance', 'clock-check'],
                    ['Payroll', 'coins'],
                ];
            @endphp

            @foreach ($navigation as [$item, $icon])

                <button
                    type="button"
                    wire:click="setView('{{ $item }}')"
                    class="group relative flex shrink-0 items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition
                        {{ $view === $item
                            ? 'bg-[#294936] text-white shadow-sm'
                            : 'text-[#718076] hover:bg-[#F4F7F1] hover:text-[#294936]' }}">

                    @switch($icon)
                        @case('users')
                            <x-tabler-users class="h-4 w-4" />
                            @break
                        @case('badge')
                            <x-tabler-badge class="h-4 w-4" />
                            @break
                        @case('calendar-event')
                            <x-tabler-calendar-event class="h-4 w-4" />
                            @break
                        @case('clock-check')
                            <x-tabler-clock-check class="h-4 w-4" />
                            @break
                        @case('coins')
                            <x-tabler-coins class="h-4 w-4" />
                            @break
                    @endswitch

                    {{ $item }}

                    @if ($view === $item)
                        <span class="ml-1 h-1.5 w-1.5 rounded-full bg-[#BBD3BD]"></span>
                    @endif
                </button>

            @endforeach

        </div>
    </div>


    {{-- ================================================================
        COMMAND STATS
    ================================================================= --}}
    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Active staff --}}
        <div class="group relative overflow-hidden rounded-[1.5rem] border border-[#DCE5DC] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#294936]/5">

            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-[#EAF1E7] transition group-hover:scale-125"></div>

            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#8A958D]">
                        Active staff
                    </p>

                    <p class="mt-3 text-3xl font-semibold tracking-tight text-[#26342A]">
                        {{ $stats['active_staff'] }}
                    </p>

                    <p class="mt-1 text-xs text-[#718076]">
                        {{ $stats['scheduled_today'] }} scheduled today
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                    <x-tabler-users class="h-5 w-5" />
                </div>
            </div>

            <div class="relative mt-5 h-1 overflow-hidden rounded-full bg-[#EDF1EC]">
                <div class="h-full w-[76%] rounded-full bg-[#5E8067]"></div>
            </div>
        </div>


        {{-- Working now --}}
        <div class="group relative overflow-hidden rounded-[1.5rem] border border-[#DCE5DC] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#294936]/5">

            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-[#E8F0E5] transition group-hover:scale-125"></div>

            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#8A958D]">
                        Working now
                    </p>

                    <p class="mt-3 text-3xl font-semibold tracking-tight text-[#26342A]">
                        {{ $stats['working_now'] }}
                    </p>

                    <p class="mt-1 flex items-center gap-1.5 text-xs text-[#5E8067]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#5E8067]"></span>
                        Currently on shift
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#5E8067]">
                    <x-tabler-clock class="h-5 w-5" />
                </div>
            </div>
        </div>


        {{-- Attendance --}}
        <div class="group relative overflow-hidden rounded-[1.5rem] border border-[#DCE5DC] bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#294936]/5">

            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-[#EEF1E9] transition group-hover:scale-125"></div>

            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#8A958D]">
                        Attendance
                    </p>

                    <p class="mt-3 text-3xl font-semibold tracking-tight text-[#26342A]">
                        {{ $stats['attendance_percent'] }}%
                    </p>

                    <p class="mt-1 text-xs text-[#718076]">
                        This pay period
                    </p>
                </div>

                <div class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-[#EEF1E9] text-[#5E8067]">
                    <x-tabler-calendar-check class="h-5 w-5" />
                </div>
            </div>
        </div>


        {{-- Payroll --}}
        <div class="group relative overflow-hidden rounded-[1.5rem] border border-[#E6DDCB] bg-[#FFFCF6] p-5 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#9A762B]/5">

            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-[#FFF0D0] transition group-hover:scale-125"></div>

            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-[#9B8B69]">
                        Pending payroll
                    </p>

                    <p class="mt-3 text-2xl font-semibold tracking-tight text-[#51442D]">
                        {{ number_format($stats['pending_payroll'], 0) }}
                        <span class="text-sm font-medium text-[#9A762B]">silver</span>
                    </p>

                    <p class="mt-1 text-xs text-[#9B8B69]">
                        Current pay period
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#FFF0D0] text-[#9A762B]">
                    <x-tabler-coins class="h-5 w-5" />
                </div>
            </div>
        </div>

    </div>


    {{-- ================================================================
        EMPLOYEES
    ================================================================= --}}
    @if ($view === 'Employees')

        <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_380px]">

            {{-- Employee directory --}}
            <section class="overflow-hidden rounded-[1.75rem] border border-[#DCE5DC] bg-white">

                <div class="border-b border-[#E7ECE7] p-5 sm:p-6">

                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="text-lg font-semibold tracking-tight text-[#26342A]">
                                    Team directory
                                </h2>

                                <span class="rounded-full bg-[#F1F4F0] px-2 py-0.5 text-[11px] font-semibold text-[#718076]">
                                    {{ $employees->count() }}
                                </span>
                            </div>

                            <p class="mt-1 text-sm text-[#829087]">
                                Everyone currently attached to your restaurant.
                            </p>
                        </div>

                        <div class="relative w-full lg:w-72">
                            <x-tabler-search class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-[#94A299]" />

                            <input
                                type="text"
                                wire:model.live.debounce.300ms="search"
                                placeholder="Find a team member..."
                                class="w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] py-2.5 pl-10 pr-4 text-sm text-[#26342A] outline-none transition placeholder:text-[#9AA69D] focus:border-[#8FA58B] focus:bg-white focus:ring-4 focus:ring-[#E8F0E5]"
                            />
                        </div>

                    </div>

                    {{-- Role filters --}}
                    <div class="mt-5 flex gap-2 overflow-x-auto pb-1">

                        @foreach ($roleFilters as $role)

                            <button
                                type="button"
                                wire:click="setRole('{{ $role }}')"
                                wire:key="filter-{{ $role }}"
                                class="whitespace-nowrap rounded-full px-3.5 py-2 text-xs font-semibold transition
                                    {{ $selectedRole === $role
                                        ? 'bg-[#294936] text-white shadow-sm'
                                        : 'border border-[#DCE5DC] bg-white text-[#718076] hover:border-[#C7D5C9] hover:bg-[#F7F9F5] hover:text-[#294936]' }}">

                                {{ $role }}

                            </button>

                        @endforeach

                    </div>

                </div>


                {{-- People --}}
                <div class="divide-y divide-[#EDF0ED]">

                    @forelse ($employees as $employee)

                        @php
                            $todayShift = $employee->shifts->first();
                            $isActive = in_array($todayShift?->status, ['working', 'completed'], true);
                            $avatar = $employee->avatarClasses();
                        @endphp

                        <button
                            type="button"
                            wire:key="employee-{{ $employee->id }}"
                            wire:click="selectEmployee({{ $employee->id }})"
                            class="group flex w-full items-center gap-4 px-5 py-4 text-left transition hover:bg-[#F8FAF6] sm:px-6
                                {{ $selectedEmployee === $employee->id ? 'bg-[#F5F8F3]' : '' }}">

                            {{-- Avatar --}}
                            <div class="relative shrink-0">

                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl text-sm font-bold transition group-hover:scale-105 {{ $avatar['bg'] }} {{ $avatar['text'] }}">
                                    {{ $employee->initials }}
                                </div>

                                <span class="absolute -bottom-0.5 -right-0.5 h-3.5 w-3.5 rounded-full border-2 border-white
                                    {{ $isActive ? 'bg-[#5E8067]' : 'bg-[#B8C0BA]' }}">
                                </span>

                            </div>


                            {{-- Identity --}}
                            <div class="min-w-0 flex-1">

                                <div class="flex items-center gap-2">
                                    <p class="truncate text-sm font-semibold text-[#26342A]">
                                        {{ $employee->full_name }}
                                    </p>

                                    @if ($isActive)
                                        <span class="hidden rounded-full bg-[#E8F0E5] px-2 py-0.5 text-[10px] font-semibold text-[#5E8067] sm:inline">
                                            {{ $todayShift?->status === 'working' ? 'Working' : 'Completed' }}
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-1 truncate text-xs text-[#829087]">
                                    {{ $employee->role?->name ?? 'Unassigned' }}
                                    <span class="mx-1 text-[#C3CCC5]">·</span>
                                    {{ $employee->department }}
                                </p>

                            </div>


                            {{-- Shift --}}
                            <div class="hidden text-right sm:block">

                                @if ($todayShift)

                                    @if ($isActive)

                                        <p class="text-sm font-semibold text-[#26342A]">
                                            {{ number_format((float) $todayShift->duration_hours, 1) }}h
                                        </p>

                                        <p class="mt-1 text-[11px] text-[#829087]">
                                            Today
                                        </p>

                                    @else

                                        <p class="text-sm font-semibold text-[#26342A]">
                                            {{ \Carbon\Carbon::parse($todayShift->start_time)->format('H:i') }}
                                        </p>

                                        <p class="mt-1 text-[11px] text-[#829087]">
                                            Starts today
                                        </p>

                                    @endif

                                @else

                                    <p class="text-sm font-medium text-[#B0B8B2]">
                                        Off
                                    </p>

                                    <p class="mt-1 text-[11px] text-[#A2ACA5]">
                                        No shift
                                    </p>

                                @endif

                            </div>


                            <x-tabler-chevron-right class="h-5 w-5 shrink-0 text-[#B2BCB5] transition group-hover:translate-x-0.5 group-hover:text-[#294936]" />

                        </button>

                    @empty

                        <div class="px-6 py-16 text-center">

                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-[#F1F4F0] text-[#829087]">
                                <x-tabler-users class="h-6 w-6" />
                            </div>

                            <p class="mt-4 text-sm font-semibold text-[#26342A]">
                                No team members found
                            </p>

                            <p class="mt-1 text-xs text-[#829087]">
                                Try changing your filters or search query.
                            </p>

                        </div>

                    @endforelse

                </div>

            </section>


            {{-- ============================================================
                EMPLOYEE PROFILE
            ============================================================= --}}
            @if ($selectedEmployeeModel)

                @php
                    $emp = $selectedEmployeeModel;
                    $empShift = $emp->shifts->first();
                    $empAttendance = $emp->attendances->first();
                    $empAvatar = $emp->avatarClasses();

                    $total = $emp->attendances()->count();
                    $presentCount = $emp->attendances()->whereIn('status', ['present', 'late'])->count();
                    $pct = $total > 0 ? round(($presentCount / $total) * 100) : 100;
                @endphp

                <aside class="overflow-hidden rounded-[1.75rem] border border-[#DCE5DC] bg-white">

                    {{-- Profile hero --}}
                    <div class="relative overflow-hidden bg-[#294936] p-6 text-white">

                        <div class="absolute -right-12 -top-16 h-44 w-44 rounded-full border-[24px] border-white/5"></div>
                        <div class="absolute -bottom-20 -left-10 h-40 w-40 rounded-full bg-white/5"></div>

                        <div class="relative">

                            <div class="flex items-start justify-between">

                                <div class="flex items-center gap-4">

                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl text-lg font-bold shadow-lg {{ $empAvatar['bg'] }} {{ $empAvatar['text'] }}">
                                        {{ $emp->initials }}
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <h2 class="font-semibold tracking-tight">
                                                {{ $emp->full_name }}
                                            </h2>

                                            <span class="h-2 w-2 rounded-full bg-[#A9D1AF]"></span>
                                        </div>

                                        <p class="mt-1 text-xs text-[#C7D9C9]">
                                            {{ $emp->role?->name ?? 'Unassigned' }}
                                        </p>
                                    </div>

                                </div>

                                <button
                                    type="button"
                                    class="rounded-xl p-2 text-white/60 transition hover:bg-white/10 hover:text-white">
                                    <x-tabler-dots class="h-5 w-5" />
                                </button>

                            </div>

                        </div>
                    </div>


                    <div class="space-y-7 p-6">

                        {{-- Today's shift --}}
                        <section>

                            <div class="flex items-center justify-between">
                                <p class="text-[11px] font-bold uppercase tracking-[0.14em] text-[#8A958D]">
                                    Today's shift
                                </p>

                                @if ($empShift)
                                    @php
                                        $badge = match ($empShift->status) {
                                            'working' => ['Working', 'bg-[#E8F0E5] text-[#5E8067]'],
                                            'completed' => ['Completed', 'bg-[#F1F3F0] text-[#718076]'],
                                            'missed' => ['Missed', 'bg-[#FBE9E7] text-[#A4483A]'],
                                            default => ['Scheduled', 'bg-[#FFF4DD] text-[#9A762B]'],
                                        };
                                    @endphp

                                    <span class="rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide {{ $badge[1] }}">
                                        {{ $badge[0] }}
                                    </span>
                                @endif

                            </div>


                            @if ($empShift)

                                <div class="mt-3 rounded-2xl bg-[#F7F9F5] p-4">

                                    <div class="flex items-center gap-4">

                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-[#294936] shadow-sm">
                                            <x-tabler-clock class="h-5 w-5" />
                                        </div>

                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-semibold text-[#26342A]">
                                                {{ $empShift->name }}
                                            </p>

                                            <p class="mt-1 text-xs text-[#829087]">
                                                {{ \Carbon\Carbon::parse($empShift->start_time)->format('H:i') }}
                                                —
                                                {{ \Carbon\Carbon::parse($empShift->end_time)->format('H:i') }}
                                            </p>
                                        </div>

                                    </div>

                                    @if ($empAttendance?->clocked_in_at)

                                        <div class="mt-4 flex items-center justify-between border-t border-[#E5EAE3] pt-3">

                                            <span class="text-xs text-[#829087]">
                                                Clocked in
                                            </span>

                                            <span class="text-xs font-semibold text-[#294936]">
                                                {{ $empAttendance->clocked_in_at->format('H:i') }}
                                            </span>

                                        </div>

                                    @endif

                                </div>

                            @else

                                <div class="mt-3 rounded-2xl border border-dashed border-[#DCE5DC] bg-[#FAFBF9] p-5 text-center">

                                    <x-tabler-calendar-off class="mx-auto h-6 w-6 text-[#A2ACA5]" />

                                    <p class="mt-2 text-xs text-[#829087]">
                                        No shift scheduled today.
                                    </p>

                                </div>

                            @endif

                        </section>


                        {{-- Metrics --}}
                        <section class="grid grid-cols-2 gap-3">

                            <div class="rounded-2xl border border-[#E3E8E2] bg-[#FAFBF9] p-4">

                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#8A958D]">
                                    Week hours
                                </p>

                                <p class="mt-2 text-xl font-semibold text-[#26342A]">
                                    {{ number_format((float) $emp->attendances()->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])->sum('hours_worked'), 1) }}
                                </p>

                                <p class="mt-1 text-[11px] text-[#829087]">
                                    Hours worked
                                </p>

                            </div>

                            <div class="rounded-2xl border border-[#E3E8E2] bg-[#FAFBF9] p-4">

                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#8A958D]">
                                    Attendance
                                </p>

                                <p class="mt-2 text-xl font-semibold text-[#26342A]">
                                    {{ $pct }}%
                                </p>

                                <div class="mt-2 h-1 overflow-hidden rounded-full bg-[#E2E8E1]">
                                    <div
                                        class="h-full rounded-full bg-[#5E8067]"
                                        style="width: {{ min($pct, 100) }}%">
                                    </div>
                                </div>

                            </div>

                        </section>


                        {{-- Contact --}}
                        <section>

                            <p class="text-[11px] font-bold uppercase tracking-[0.14em] text-[#8A958D]">
                                Contact
                            </p>

                            <div class="mt-3 space-y-3">

                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#F1F4F0] text-[#8FA58B]">
                                        <x-tabler-mail class="h-4 w-4" />
                                    </div>

                                    <span class="truncate text-xs text-[#718076]">
                                        {{ $emp->email }}
                                    </span>
                                </div>

                                @if ($emp->phone)

                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#F1F4F0] text-[#8FA58B]">
                                            <x-tabler-phone class="h-4 w-4" />
                                        </div>

                                        <span class="text-xs text-[#718076]">
                                            {{ $emp->phone }}
                                        </span>
                                    </div>

                                @endif

                                @if ($emp->joined_at)

                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#F1F4F0] text-[#8FA58B]">
                                            <x-tabler-calendar class="h-4 w-4" />
                                        </div>

                                        <span class="text-xs text-[#718076]">
                                            Joined {{ $emp->joined_at->format('jS M Y') }}
                                        </span>
                                    </div>

                                @endif

                            </div>

                        </section>


                        {{-- Actions --}}
                        <div class="grid grid-cols-2 gap-2">

                            <button
                                type="button"
                                wire:click="createShift"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#294936] px-3 py-2.5 text-xs font-semibold text-white transition hover:bg-[#183524]">
                                <x-tabler-calendar-plus class="h-4 w-4" />
                                Schedule
                            </button>

                            <button
                                type="button"
                                class="inline-flex items-center justify-center gap-2 rounded-xl border border-[#DCE5DC] bg-white px-3 py-2.5 text-xs font-semibold text-[#294936] transition hover:bg-[#F7F9F5]">
                                <x-tabler-history class="h-4 w-4" />
                                History
                            </button>

                        </div>

                    </div>

                </aside>

            @else

                {{-- Empty profile state --}}
                <aside class="hidden rounded-[1.75rem] border border-dashed border-[#DCE5DC] bg-[#FAFBF9] p-8 xl:flex xl:min-h-[500px] xl:flex-col xl:items-center xl:justify-center xl:text-center">

                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF0E7] text-[#5E8067]">
                        <x-tabler-user-search class="h-7 w-7" />
                    </div>

                    <h3 class="mt-5 text-sm font-semibold text-[#26342A]">
                        Select a team member
                    </h3>

                    <p class="mt-2 max-w-[230px] text-xs leading-5 text-[#829087]">
                        Choose someone from the directory to inspect their shift, attendance, and contact details.
                    </p>

                </aside>

            @endif

        </div>

    @endif


    {{-- ================================================================
        ROLES
    ================================================================= --}}
    @if ($view === 'Roles')

        <section class="overflow-hidden rounded-[1.75rem] border border-[#DCE5DC] bg-white">

            <div class="border-b border-[#E7ECE7] p-5 sm:p-6">

                <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-lg font-semibold tracking-tight text-[#26342A]">
                                Roles & pay
                            </h2>

                            <span class="rounded-full bg-[#F1F4F0] px-2 py-0.5 text-[11px] font-semibold text-[#718076]">
                                {{ $roleList->count() }}
                            </span>
                        </div>

                        <p class="mt-1 text-sm text-[#829087]">
                            Define positions, departments, and base compensation.
                        </p>
                    </div>

                    <div class="flex flex-col gap-2 sm:flex-row">

                        <div class="relative">
                            <x-tabler-search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#94A299]" />

                            <input
                                type="text"
                                wire:model.live.debounce.300ms="roleSearch"
                                placeholder="Search roles..."
                                class="w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] py-2.5 pl-9 pr-3 text-sm outline-none focus:border-[#8FA58B] focus:bg-white focus:ring-4 focus:ring-[#E8F0E5] sm:w-56"
                            />
                        </div>

                        <button
                            type="button"
                            wire:click="addRole"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#294936] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#183524]">
                            <x-tabler-plus class="h-4 w-4" />
                            Add role
                        </button>

                    </div>

                </div>


                <div class="mt-5 flex gap-2 overflow-x-auto pb-1">

                    @foreach (array_merge(['all'], $departments) as $dept)

                        <button
                            type="button"
                            wire:click="$set('roleFilterDepartment', '{{ $dept }}')"
                            wire:key="dept-{{ $dept }}"
                            class="whitespace-nowrap rounded-full px-3.5 py-2 text-xs font-semibold transition
                                {{ $roleFilterDepartment === $dept
                                    ? 'bg-[#294936] text-white'
                                    : 'border border-[#DCE5DC] bg-white text-[#718076] hover:bg-[#F8FAF6]' }}">

                            {{ $dept === 'all' ? 'All departments' : $dept }}

                        </button>

                    @endforeach

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full min-w-[760px] text-sm">

                    <thead class="bg-[#F8FAF6]">
                        <tr class="border-b border-[#E7ECE7]">

                            <th class="px-6 py-3 text-left text-[10px] font-bold uppercase tracking-[0.12em] text-[#829087]">
                                Role
                            </th>

                            <th class="px-6 py-3 text-left text-[10px] font-bold uppercase tracking-[0.12em] text-[#829087]">
                                Department
                            </th>

                            <th class="px-6 py-3 text-left text-[10px] font-bold uppercase tracking-[0.12em] text-[#829087]">
                                Base rate
                            </th>

                            <th class="px-6 py-3 text-left text-[10px] font-bold uppercase tracking-[0.12em] text-[#829087]">
                                Team
                            </th>

                            <th class="px-6 py-3 text-right text-[10px] font-bold uppercase tracking-[0.12em] text-[#829087]">
                                Actions
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#EDF0ED]">

                        @forelse ($roleList as $role)

                            <tr
                                wire:key="role-{{ $role->id }}"
                                class="group transition hover:bg-[#FAFBF9]">

                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#E8F0E5] text-[#294936]">
                                            <x-tabler-badge class="h-5 w-5" />
                                        </div>

                                        <div>
                                            <p class="font-semibold text-[#26342A]">
                                                {{ $role->name }}
                                            </p>

                                            <p class="mt-0.5 text-[11px] text-[#9AA69D]">
                                                {{ $role->slug }}
                                            </p>
                                        </div>

                                    </div>

                                </td>

                                <td class="px-6 py-4">
                                    <span class="rounded-full bg-[#F0F4EF] px-2.5 py-1 text-[11px] font-semibold text-[#294936]">
                                        {{ $role->department }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 font-semibold text-[#26342A]">
                                    {{ number_format((float) $role->base_hourly_rate, 2) }}
                                    <span class="text-[11px] font-medium text-[#829087]">
                                        silver/hr
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="text-[#718076]">
                                        {{ $role->employees_count }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-end gap-2">

                                        <button
                                            type="button"
                                            wire:click="editRole({{ $role->id }})"
                                            class="rounded-lg border border-[#DCE5DC] px-3 py-1.5 text-xs font-semibold text-[#294936] transition hover:bg-[#E8F0E5]">
                                            Edit
                                        </button>

                                        <button
                                            type="button"
                                            wire:click="deleteRole({{ $role->id }})"
                                            wire:confirm="Delete this role? Employees will be unassigned."
                                            class="rounded-lg px-3 py-1.5 text-xs font-semibold text-[#A4483A] transition hover:bg-[#FBE9E7]">
                                            Delete
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-sm text-[#829087]">
                                    No roles found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    @endif


    {{-- ================================================================
        SHIFTS
    ================================================================= --}}
    @if ($view === 'Shifts')

        <section class="overflow-hidden rounded-[1.75rem] border border-[#DCE5DC] bg-white">

            <div class="border-b border-[#E7ECE7] p-5 sm:p-6">

                <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

                    <div>
                        <h2 class="text-lg font-semibold tracking-tight text-[#26342A]">
                            Shift board
                        </h2>

                        <p class="mt-1 text-sm text-[#829087]">
                            See who's scheduled, when, and for how long.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="createShift"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#294936] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#183524]">
                        <x-tabler-plus class="h-4 w-4" />
                        New shift
                    </button>

                </div>


                <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#829087]">
                            Employee
                        </label>

                        <select
                            wire:model.live="shiftFilterEmployee"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm text-[#26342A] outline-none focus:border-[#8FA58B] focus:bg-white">
                            <option value="">All employees</option>

                            @foreach ($allEmployees as $e)
                                <option value="{{ $e->id }}">
                                    {{ $e->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#829087]">
                            Status
                        </label>

                        <select
                            wire:model.live="shiftFilterStatus"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm text-[#26342A] outline-none focus:border-[#8FA58B] focus:bg-white">
                            <option value="all">All statuses</option>

                            @foreach ($shiftStatuses as $s)
                                <option value="{{ $s }}">
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#829087]">
                            From
                        </label>

                        <input
                            type="date"
                            wire:model.live="shiftFilterFrom"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm text-[#26342A] outline-none focus:border-[#8FA58B] focus:bg-white"
                        />
                    </div>


                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#829087]">
                            To
                        </label>

                        <input
                            type="date"
                            wire:model.live="shiftFilterTo"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm text-[#26342A] outline-none focus:border-[#8FA58B] focus:bg-white"
                        />
                    </div>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full min-w-[900px] text-sm">

                    <thead class="bg-[#F8FAF6]">
                        <tr class="border-b border-[#E7ECE7]">

                            @foreach (['Employee', 'Shift', 'Date', 'Time', 'Duration', 'Status', ''] as $heading)

                                <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[0.12em] text-[#829087]">
                                    {{ $heading }}
                                </th>

                            @endforeach

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#EDF0ED]">

                        @forelse ($shifts as $shift)

                            @php
                                $avatar = $shift->employee?->avatarClasses()
                                    ?? ['bg' => 'bg-[#E8F0E5]', 'text' => 'text-[#294936]'];
                            @endphp

                            <tr
                                wire:key="shift-{{ $shift->id }}"
                                class="transition hover:bg-[#FAFBF9]">

                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 items-center justify-center rounded-xl text-xs font-bold {{ $avatar['bg'] }} {{ $avatar['text'] }}">
                                            {{ $shift->employee?->initials ?? '—' }}
                                        </div>

                                        <div>
                                            <p class="font-semibold text-[#26342A]">
                                                {{ $shift->employee?->full_name ?? 'Unassigned' }}
                                            </p>

                                            <p class="text-[11px] text-[#829087]">
                                                {{ $shift->employee?->department }}
                                            </p>
                                        </div>

                                    </div>

                                </td>

                                <td class="px-5 py-4 font-medium text-[#26342A]">
                                    {{ $shift->name }}
                                </td>

                                <td class="px-5 py-4 text-[#718076]">
                                    {{ $shift->shift_date->format('D, j M Y') }}
                                </td>

                                <td class="px-5 py-4 text-[#718076]">
                                    {{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }}
                                    —
                                    {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                                </td>

                                <td class="px-5 py-4 font-semibold text-[#26342A]">
                                    {{ number_format((float) $shift->duration_hours, 1) }}h
                                </td>

                                <td class="px-5 py-4">

                                    <select
                                        wire:change="updateShiftStatus({{ $shift->id }}, $event.target.value)"
                                        class="rounded-full border border-[#DCE5DC] bg-white px-2.5 py-1.5 text-xs font-semibold text-[#294936] outline-none">

                                        @foreach ($shiftStatuses as $s)
                                            <option value="{{ $s }}" @selected($shift->status === $s)>
                                                {{ ucfirst($s) }}
                                            </option>
                                        @endforeach

                                    </select>

                                </td>

                                <td class="px-5 py-4 text-right">

                                    <button
                                        type="button"
                                        wire:click="deleteShift({{ $shift->id }})"
                                        wire:confirm="Delete this shift?"
                                        class="rounded-lg p-2 text-[#A2ACA5] transition hover:bg-[#FBE9E7] hover:text-[#A4483A]">

                                        <x-tabler-trash class="h-4 w-4" />

                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="px-5 py-16 text-center text-sm text-[#829087]">
                                    No shifts match your filters.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($shifts->hasPages())
                <div class="border-t border-[#E7ECE7] px-5 py-4">
                    {{ $shifts->links() }}
                </div>
            @endif

        </section>

    @endif


    {{-- ================================================================
        ATTENDANCE
    ================================================================= --}}
    @if ($view === 'Attendance')

        <section class="overflow-hidden rounded-[1.75rem] border border-[#DCE5DC] bg-white">

            <div class="border-b border-[#E7ECE7] p-5 sm:p-6">

                <div>
                    <h2 class="text-lg font-semibold tracking-tight text-[#26342A]">
                        Attendance ledger
                    </h2>

                    <p class="mt-1 text-sm text-[#829087]">
                        Clock-ins, clock-outs, absences, and hours worked.
                    </p>
                </div>


                <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#829087]">
                            Employee
                        </label>

                        <select wire:model.live="attendanceFilterEmployee"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]">
                            <option value="">All employees</option>

                            @foreach ($allEmployees as $e)
                                <option value="{{ $e->id }}">{{ $e->full_name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#829087]">
                            Status
                        </label>

                        <select wire:model.live="attendanceFilterStatus"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]">
                            <option value="all">All statuses</option>

                            @foreach ($attendanceStatuses as $s)
                                <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#829087]">
                            From
                        </label>

                        <input type="date"
                            wire:model.live="attendanceFilterFrom"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]"
                        />
                    </div>


                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#829087]">
                            To
                        </label>

                        <input type="date"
                            wire:model.live="attendanceFilterTo"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]"
                        />
                    </div>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full min-w-[900px] text-sm">

                    <thead class="bg-[#F8FAF6]">
                        <tr class="border-b border-[#E7ECE7]">

                            @foreach (['Employee', 'Date', 'Shift', 'Clock in', 'Clock out', 'Hours', 'Status', ''] as $heading)

                                <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[0.12em] text-[#829087]">
                                    {{ $heading }}
                                </th>

                            @endforeach

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#EDF0ED]">

                        @forelse ($attendance as $record)

                            @php

                                $avatar = $record->employee?->avatarClasses()
                                    ?? ['bg' => 'bg-[#E8F0E5]', 'text' => 'text-[#294936]'];

                                $badge = match ($record->status) {
                                    'present' => ['Present', 'bg-[#E8F0E5] text-[#5E8067]'],
                                    'late' => ['Late', 'bg-[#FFF4DD] text-[#9A762B]'],
                                    'absent' => ['Absent', 'bg-[#FBE9E7] text-[#A4483A]'],
                                    'leave' => ['Leave', 'bg-[#F1F3F0] text-[#718076]'],
                                    default => [ucfirst($record->status), 'bg-[#F1F3F0] text-[#718076]'],
                                };

                            @endphp

                            <tr wire:key="att-{{ $record->id }}" class="transition hover:bg-[#FAFBF9]">

                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 items-center justify-center rounded-xl text-xs font-bold {{ $avatar['bg'] }} {{ $avatar['text'] }}">
                                            {{ $record->employee?->initials ?? '—' }}
                                        </div>

                                        <div>
                                            <p class="font-semibold text-[#26342A]">
                                                {{ $record->employee?->full_name }}
                                            </p>

                                            <p class="text-[11px] text-[#829087]">
                                                {{ $record->employee?->role?->name }}
                                            </p>
                                        </div>

                                    </div>

                                </td>

                                <td class="px-5 py-4 text-[#718076]">
                                    {{ $record->date->format('D, j M Y') }}
                                </td>

                                <td class="px-5 py-4 text-[#718076]">
                                    {{ $record->shift?->name ?? '—' }}
                                </td>

                                <td class="px-5 py-4 font-medium text-[#26342A]">
                                    {{ $record->clocked_in_at?->format('H:i') ?? '—' }}
                                </td>

                                <td class="px-5 py-4 font-medium text-[#26342A]">
                                    {{ $record->clocked_out_at?->format('H:i') ?? '—' }}
                                </td>

                                <td class="px-5 py-4 font-semibold text-[#26342A]">
                                    {{ number_format((float) $record->hours_worked, 2) }}h
                                </td>

                                <td class="px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $badge[1] }}">
                                        {{ $badge[0] }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-right">

                                    @if ($record->clocked_in_at && !$record->clocked_out_at)

                                        <button
                                            type="button"
                                            wire:click="clockOut({{ $record->id }})"
                                            class="rounded-lg bg-[#294936] px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-[#183524]">
                                            Clock out
                                        </button>

                                    @else

                                        <span class="text-xs text-[#B0B8B2]">—</span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="px-5 py-16 text-center text-sm text-[#829087]">
                                    No attendance records match your filters.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($attendance->hasPages())
                <div class="border-t border-[#E7ECE7] px-5 py-4">
                    {{ $attendance->links() }}
                </div>
            @endif

        </section>

    @endif


    {{-- ================================================================
        PAYROLL
    ================================================================= --}}
    @if ($view === 'Payroll')

        <section class="overflow-hidden rounded-[1.75rem] border border-[#DCE5DC] bg-white">

            <div class="border-b border-[#E7ECE7] p-5 sm:p-6">

                <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-lg font-semibold tracking-tight text-[#26342A]">
                                Payroll
                            </h2>

                            <span class="rounded-full bg-[#FFF4DD] px-2.5 py-1 text-[10px] font-bold text-[#9A762B]">
                                Settlement
                            </span>
                        </div>

                        <p class="mt-1 text-sm text-[#829087]">
                            Review hours, amounts, and payment status.
                        </p>
                    </div>

                </div>


                <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">

                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#829087]">
                            Employee
                        </label>

                        <select wire:model.live="payrollFilterEmployee"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]">
                            <option value="">All employees</option>

                            @foreach ($allEmployees as $e)
                                <option value="{{ $e->id }}">{{ $e->full_name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#829087]">
                            Status
                        </label>

                        <select wire:model.live="payrollFilterStatus"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]">
                            <option value="all">All statuses</option>

                            @foreach ($payrollStatuses as $s)
                                <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#829087]">
                            Period from
                        </label>

                        <input type="date"
                            wire:model.live="payrollFilterFrom"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]"
                        />
                    </div>


                    <div>
                        <label class="text-[10px] font-bold uppercase tracking-wider text-[#829087]">
                            Period to
                        </label>

                        <input type="date"
                            wire:model.live="payrollFilterTo"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]"
                        />
                    </div>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full min-w-[900px] text-sm">

                    <thead class="bg-[#F8FAF6]">
                        <tr class="border-b border-[#E7ECE7]">

                            @foreach (['Employee', 'Period', 'Hours', 'Amount', 'Status', 'Paid', ''] as $heading)

                                <th class="px-5 py-3 text-left text-[10px] font-bold uppercase tracking-[0.12em] text-[#829087]">
                                    {{ $heading }}
                                </th>

                            @endforeach

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#EDF0ED]">

                        @forelse ($payroll as $row)

                            @php

                                $avatar = $row->employee?->avatarClasses()
                                    ?? ['bg' => 'bg-[#E8F0E5]', 'text' => 'text-[#294936]'];

                                $badge = match ($row->status) {
                                    'paid' => ['Paid', 'bg-[#E8F0E5] text-[#5E8067]'],
                                    'cancelled' => ['Cancelled', 'bg-[#FBE9E7] text-[#A4483A]'],
                                    default => ['Pending', 'bg-[#FFF4DD] text-[#9A762B]'],
                                };

                            @endphp

                            <tr wire:key="pr-{{ $row->id }}" class="transition hover:bg-[#FAFBF9]">

                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 items-center justify-center rounded-xl text-xs font-bold {{ $avatar['bg'] }} {{ $avatar['text'] }}">
                                            {{ $row->employee?->initials ?? '—' }}
                                        </div>

                                        <div>
                                            <p class="font-semibold text-[#26342A]">
                                                {{ $row->employee?->full_name }}
                                            </p>

                                            <p class="text-[11px] text-[#829087]">
                                                {{ $row->employee?->role?->name }}
                                            </p>
                                        </div>

                                    </div>

                                </td>

                                <td class="px-5 py-4 text-[#718076]">
                                    {{ $row->period_start->format('j M') }}
                                    —
                                    {{ $row->period_end->format('j M Y') }}
                                </td>

                                <td class="px-5 py-4 font-semibold text-[#26342A]">
                                    {{ number_format((float) $row->hours_worked, 1) }}h
                                </td>

                                <td class="px-5 py-4">

                                    <span class="font-semibold text-[#26342A]">
                                        {{ number_format((float) $row->amount, 2) }}
                                    </span>

                                    <span class="text-[11px] text-[#829087]">
                                        {{ $row->currency }}
                                    </span>

                                </td>

                                <td class="px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $badge[1] }}">
                                        {{ $badge[0] }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-[#718076]">
                                    {{ $row->paid_at?->format('j M Y') ?? '—' }}
                                </td>

                                <td class="px-5 py-4 text-right">

                                    @if ($row->status === 'pending')

                                        <div class="flex justify-end gap-2">

                                            <button
                                                type="button"
                                                wire:click="markPayrollPaid({{ $row->id }})"
                                                class="rounded-lg bg-[#294936] px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-[#183524]">
                                                Mark paid
                                            </button>

                                            <button
                                                type="button"
                                                wire:click="cancelPayroll({{ $row->id }})"
                                                wire:confirm="Cancel this payroll?"
                                                class="rounded-lg px-3 py-1.5 text-xs font-semibold text-[#A4483A] transition hover:bg-[#FBE9E7]">
                                                Cancel
                                            </button>

                                        </div>

                                    @else

                                        <span class="text-xs text-[#B0B8B2]">—</span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="px-5 py-16 text-center text-sm text-[#829087]">
                                    No payroll records match your filters.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($payroll->hasPages())
                <div class="border-t border-[#E7ECE7] px-5 py-4">
                    {{ $payroll->links() }}
                </div>
            @endif

        </section>

    @endif


    {{-- ================================================================
        ADD EMPLOYEE MODAL
    ================================================================= --}}
    @if ($showEmployeeModal)

        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-[#162019]/60 p-4 backdrop-blur-sm"
            wire:click.self="$set('showEmployeeModal', false)">

            <div class="w-full max-w-lg overflow-hidden rounded-[1.75rem] bg-white shadow-2xl">

                <div class="border-b border-[#E7ECE7] bg-[#F8FAF6] p-6">

                    <div class="flex items-center gap-4">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#294936] text-white">
                            <x-tabler-user-plus class="h-5 w-5" />
                        </div>

                        <div>
                            <h3 class="font-semibold text-[#26342A]">
                                Add employee
                            </h3>

                            <p class="mt-1 text-xs text-[#829087]">
                                Add a new member to your team.
                            </p>
                        </div>

                    </div>

                </div>


                <form wire:submit="saveEmployee" class="space-y-4 p-6">

                    <div class="grid grid-cols-2 gap-3">

                        <div>
                            <label class="text-xs font-semibold text-[#718076]">First name</label>

                            <input
                                type="text"
                                wire:model="employeeForm.first_name"
                                class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B] focus:bg-white"
                            />

                            @error('employeeForm.first_name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div>
                            <label class="text-xs font-semibold text-[#718076]">Last name</label>

                            <input
                                type="text"
                                wire:model="employeeForm.last_name"
                                class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B] focus:bg-white"
                            />

                            @error('employeeForm.last_name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>


                    <div>
                        <label class="text-xs font-semibold text-[#718076]">Email</label>

                        <input
                            type="email"
                            wire:model="employeeForm.email"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B] focus:bg-white"
                        />

                        @error('employeeForm.email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label class="text-xs font-semibold text-[#718076]">Phone</label>

                        <input
                            type="text"
                            wire:model="employeeForm.phone"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B] focus:bg-white"
                        />
                    </div>


                    <div class="grid grid-cols-2 gap-3">

                        <div>
                            <label class="text-xs font-semibold text-[#718076]">Role</label>

                            <select
                                wire:model="employeeForm.role_id"
                                class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B] focus:bg-white">
                                <option value="">— Select —</option>

                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div>
                            <label class="text-xs font-semibold text-[#718076]">Department</label>

                            <select
                                wire:model="employeeForm.department"
                                class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B] focus:bg-white">

                                @foreach ($departments as $dept)
                                    <option value="{{ $dept }}">{{ $dept }}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>


                    <div>
                        <label class="text-xs font-semibold text-[#718076]">Avatar colour</label>

                        <select
                            wire:model="employeeForm.avatar_color"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B] focus:bg-white">
                            <option value="green">Green</option>
                            <option value="tan">Tan</option>
                            <option value="amber">Amber</option>
                            <option value="gray">Gray</option>
                        </select>
                    </div>


                    <div class="flex justify-end gap-2 border-t border-[#EDF0ED] pt-5">

                        <button
                            type="button"
                            wire:click="$set('showEmployeeModal', false)"
                            class="rounded-xl border border-[#DCE5DC] px-5 py-2.5 text-sm font-semibold text-[#718076] transition hover:bg-[#F8FAF6]">
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="rounded-xl bg-[#294936] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#183524]">
                            Save employee
                        </button>

                    </div>

                </form>

            </div>

        </div>

    @endif


    {{-- ================================================================
        CREATE SHIFT MODAL
    ================================================================= --}}
    @if ($showShiftModal)

        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-[#162019]/60 p-4 backdrop-blur-sm"
            wire:click.self="$set('showShiftModal', false)">

            <div class="w-full max-w-lg overflow-hidden rounded-[1.75rem] bg-white shadow-2xl">

                <div class="border-b border-[#E7ECE7] bg-[#F8FAF6] p-6">

                    <div class="flex items-center gap-4">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#294936] text-white">
                            <x-tabler-calendar-plus class="h-5 w-5" />
                        </div>

                        <div>
                            <h3 class="font-semibold text-[#26342A]">
                                Create shift
                            </h3>

                            <p class="mt-1 text-xs text-[#829087]">
                                Put someone on the floor.
                            </p>
                        </div>

                    </div>

                </div>


                <form wire:submit="saveShift" class="space-y-4 p-6">

                    <div>
                        <label class="text-xs font-semibold text-[#718076]">Employee</label>

                        <select
                            wire:model="shiftForm.employee_id"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]">

                            <option value="">— Select —</option>

                            @foreach ($allEmployees as $e)
                                <option value="{{ $e->id }}">{{ $e->full_name }}</option>
                            @endforeach

                        </select>

                        @error('shiftForm.employee_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label class="text-xs font-semibold text-[#718076]">Shift name</label>

                        <input
                            type="text"
                            wire:model="shiftForm.name"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]"
                        />

                        @error('shiftForm.name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label class="text-xs font-semibold text-[#718076]">Date</label>

                        <input
                            type="date"
                            wire:model="shiftForm.shift_date"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]"
                        />

                        @error('shiftForm.shift_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="grid grid-cols-2 gap-3">

                        <div>
                            <label class="text-xs font-semibold text-[#718076]">Start</label>

                            <input
                                type="time"
                                wire:model="shiftForm.start_time"
                                class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]"
                            />
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-[#718076]">End</label>

                            <input
                                type="time"
                                wire:model="shiftForm.end_time"
                                class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]"
                            />
                        </div>

                    </div>


                    <div>
                        <label class="text-xs font-semibold text-[#718076]">Status</label>

                        <select
                            wire:model="shiftForm.status"
                            class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]">

                            @foreach ($shiftStatuses as $s)
                                <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                            @endforeach

                        </select>
                    </div>


                    <div class="flex justify-end gap-2 border-t border-[#EDF0ED] pt-5">

                        <button
                            type="button"
                            wire:click="$set('showShiftModal', false)"
                            class="rounded-xl border border-[#DCE5DC] px-5 py-2.5 text-sm font-semibold text-[#718076] hover:bg-[#F8FAF6]">
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="rounded-xl bg-[#294936] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#183524]">
                            Save shift
                        </button>

                    </div>

                </form>

            </div>

        </div>

    @endif


    {{-- ================================================================
        ROLE MODAL
    ================================================================= --}}
    @if ($showRoleModal)

        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-[#162019]/60 p-4 backdrop-blur-sm"
            wire:click.self="$set('showRoleModal', false)">

            <div class="w-full max-w-lg overflow-hidden rounded-[1.75rem] bg-white shadow-2xl">

                <div class="border-b border-[#E7ECE7] bg-[#F8FAF6] p-6">

                    <div class="flex items-center gap-4">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#294936] text-white">
                            <x-tabler-badge class="h-5 w-5" />
                        </div>

                        <div>
                            <h3 class="font-semibold text-[#26342A]">
                                {{ $editingRoleId ? 'Edit role' : 'Add role' }}
                            </h3>

                            <p class="mt-1 text-xs text-[#829087]">
                                Define the position and its compensation.
                            </p>
                        </div>

                    </div>

                </div>


                <form wire:submit="saveRole" class="space-y-4 p-6">

                    <div class="grid grid-cols-2 gap-3">

                        <div>
                            <label class="text-xs font-semibold text-[#718076]">Name</label>

                            <input
                                type="text"
                                wire:model="roleForm.name"
                                class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]"
                            />

                            @error('roleForm.name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-[#718076]">Slug</label>

                            <input
                                type="text"
                                wire:model="roleForm.slug"
                                class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]"
                            />

                            @error('roleForm.slug')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>


                    <div class="grid grid-cols-2 gap-3">

                        <div>
                            <label class="text-xs font-semibold text-[#718076]">Department</label>

                            <select
                                wire:model="roleForm.department"
                                class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]">

                                @foreach ($departments as $dept)
                                    <option value="{{ $dept }}">{{ $dept }}</option>
                                @endforeach

                            </select>
                        </div>


                        <div>
                            <label class="text-xs font-semibold text-[#718076]">Base hourly rate</label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                wire:model="roleForm.base_hourly_rate"
                                class="mt-1.5 w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]"
                            />

                            @error('roleForm.base_hourly_rate')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>


                    <div>
                        <label class="text-xs font-semibold text-[#718076]">
                            Description
                        </label>

                        <textarea
                            rows="3"
                            wire:model="roleForm.description"
                            class="mt-1.5 w-full resize-none rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] px-3 py-2.5 text-sm outline-none focus:border-[#8FA58B]">
                        </textarea>
                    </div>


                    <div class="flex justify-end gap-2 border-t border-[#EDF0ED] pt-5">

                        <button
                            type="button"
                            wire:click="$set('showRoleModal', false)"
                            class="rounded-xl border border-[#DCE5DC] px-5 py-2.5 text-sm font-semibold text-[#718076] hover:bg-[#F8FAF6]">
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="rounded-xl bg-[#294936] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#183524]">
                            {{ $editingRoleId ? 'Update role' : 'Save role' }}
                        </button>

                    </div>

                </form>

            </div>

        </div>

    @endif

</div>
{{-- ================================================================
MOBILE HEADER
================================================================ --}}

<header class="flex h-16 items-center justify-between border-b border-[#DCE5DC] bg-white px-4 lg:hidden">

    <a href="{{ route('dashboard') }}"
        class="flex items-center gap-2 text-base font-semibold tracking-[0.18em] text-[#294936]">
        <x-tabler-leaf class="h-5 w-5 text-[#5E8067]" stroke-width="1.5" />

        SERVORA
    </a>

    <button type="button" @click="sidebarOpen = true"
        class="flex h-9 w-9 items-center justify-center rounded-lg text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936]"
        aria-label="Open navigation">
        <x-tabler-menu class="h-5 w-5" stroke-width="1.5" />
    </button>

</header>


{{-- ================================================================
MOBILE OVERLAY
================================================================ --}}

<div x-cloak x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
    class="fixed inset-0 z-40 bg-[#294936]/20 backdrop-blur-[2px] lg:hidden"></div>


{{-- ================================================================
SIDEBAR
================================================================ --}}

<aside
    class="fixed inset-y-0 left-0 z-50 flex w-72 max-w-[85vw] -translate-x-full flex-col border-r border-[#DCE5DC] bg-white transition-[width,transform] duration-200 ease-out lg:z-40 lg:max-w-none lg:translate-x-0"
    :class="[
        sidebarOpen ? 'translate-x-0' : '-translate-x-full',
        collapsed ? 'lg:w-[72px]' : 'lg:w-64'
    ]">

    <div class="flex h-full min-h-0 flex-col">


        {{-- ========================================================
        BRAND
        ========================================================= --}}

        <div class="relative flex h-20 shrink-0 items-center border-b border-[#DCE5DC] transition-all duration-200"
            :class="collapsed ? 'justify-center px-2' : 'justify-between px-6'">

            {{-- Expanded logo --}}
            <a href="{{ route('dashboard') }}" x-show="!collapsed"
                class="flex items-center gap-2 text-lg font-semibold tracking-[0.18em] text-[#294936]">
                <x-tabler-leaf class="h-5 w-5 shrink-0 text-[#5E8067]" stroke-width="1.5" />

                <span>SERVORA</span>
            </a>


            {{-- Collapsed logo --}}
            <a href="{{ route('dashboard') }}" x-show="collapsed" x-cloak class="flex items-center justify-center">
                <x-tabler-leaf class="h-6 w-6 text-[#5E8067]" stroke-width="1.5" />
            </a>


            {{-- Desktop collapse button --}}
            <button type="button" @click="toggleCollapse()"
                class="absolute hidden h-8 w-8 items-center justify-center rounded-lg border border-[#DCE5DC] bg-white text-[#8A968D] shadow-sm transition hover:bg-[#F8FAF6] hover:text-[#294936] lg:flex"
                :class="collapsed
                    ? 'left-[56px] top-6'
                    : 'right-3 top-6'" :aria-label="collapsed ? 'Expand sidebar' : 'Collapse sidebar'">

                <template x-if="!collapsed">
                    <x-tabler-layout-sidebar-left-collapse class="h-4 w-4" stroke-width="1.5" />
                </template>

                <template x-if="collapsed">
                    <x-tabler-layout-sidebar-left-expand class="h-4 w-4" stroke-width="1.5" />
                </template>

            </button>


            {{-- Mobile close --}}
            <button type="button" @click="sidebarOpen = false"
                class="flex h-9 w-9 items-center justify-center rounded-lg text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936] lg:hidden"
                aria-label="Close navigation">
                <x-tabler-x class="h-5 w-5" stroke-width="1.5" />
            </button>

        </div>


        {{-- ========================================================
        NAVIGATION
        ========================================================= --}}

        <nav class="min-h-0 flex-1 overflow-x-hidden overflow-y-auto py-6 transition-all duration-200"
            :class="collapsed ? 'px-2' : 'px-4'">

            {{-- ====================================================
            WORKSPACE
            ===================================================== --}}

            <section>

                <p x-show="!collapsed" class="px-3 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#A1ACA3]">
                    Workspace
                </p>


                <div class="mt-3 space-y-1">

                    <x-servora.dashboard.sidebar-link route="dashboard" icon="layout-dashboard" :collapsed="true">
                        Dashboard
                    </x-servora.dashboard.sidebar-link>


                    <x-servora.dashboard.sidebar-link route="reservations" icon="calendar-event" :collapsed="true">
                        Reservations
                    </x-servora.dashboard.sidebar-link>


                    <x-servora.dashboard.sidebar-link route="dashboard.menu" icon="tools-kitchen-2" :collapsed="true">
                        Menu
                    </x-servora.dashboard.sidebar-link>


                    <x-servora.dashboard.sidebar-link route="dashboard.events" icon="calendar-star" :collapsed="true">
                        Events
                    </x-servora.dashboard.sidebar-link>


                    <x-servora.dashboard.sidebar-link route="dashboard.reviews" icon="star" :collapsed="true">
                        Reviews
                    </x-servora.dashboard.sidebar-link>


                    <x-servora.dashboard.sidebar-link route="pos" icon="cash-register" :collapsed="true">
                        Point of Sale
                    </x-servora.dashboard.sidebar-link>


                    <x-servora.dashboard.sidebar-link route="orders" icon="receipt" badge="12" :collapsed="true">
                        Orders
                    </x-servora.dashboard.sidebar-link>


                    <x-servora.dashboard.sidebar-link route="kitchen" icon="tools-kitchen-2" :collapsed="true">
                        Kitchen
                    </x-servora.dashboard.sidebar-link>

                </div>

            </section>


            {{-- ====================================================
            MANAGE
            ===================================================== --}}

            <section class="mt-8">

                <p x-show="!collapsed" class="px-3 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#A1ACA3]">
                    Manage
                </p>


                <div class="mt-3 space-y-1">

                    <x-servora.dashboard.sidebar-link route="staff" icon="users" :collapsed="true">
                        Staff
                    </x-servora.dashboard.sidebar-link>


                    <x-servora.dashboard.sidebar-link route="tables" icon="layout-grid" :collapsed="true">
                        Tables
                    </x-servora.dashboard.sidebar-link>


                    <x-servora.dashboard.sidebar-link route="guests" icon="users" :collapsed="true">
                        Guests
                    </x-servora.dashboard.sidebar-link>


                    <x-servora.dashboard.sidebar-link route="inventory" icon="package" :collapsed="true">
                        Inventory
                    </x-servora.dashboard.sidebar-link>


                    <x-servora.dashboard.sidebar-link route="reports" icon="chart-bar" :collapsed="true">
                        Reports
                    </x-servora.dashboard.sidebar-link>

                </div>

            </section>

        </nav>


        {{-- ========================================================
        USER
        ========================================================= --}}

        <div class="shrink-0 border-t border-[#DCE5DC] transition-all duration-200" :class="collapsed ? 'p-2' : 'p-4'">

            <a href="#" class="flex items-center rounded-xl p-2 transition hover:bg-[#F8FAF6]"
                :class="collapsed ? 'justify-center' : 'gap-3'">

                {{-- Avatar --}}
                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#E8F0E5]">
                    <span class="text-sm font-semibold text-[#294936]">
                        A
                    </span>
                </div>


                {{-- User information --}}
                <div x-show="!collapsed" class="min-w-0 flex-1">

                    <p class="truncate text-sm font-medium text-[#294936]">
                        Admin
                    </p>

                    <p class="truncate text-xs text-[#8A968D]">
                        admin@servora.test
                    </p>

                </div>


                {{-- More --}}
                <x-tabler-dots x-show="!collapsed" class="h-4 w-4 shrink-0 text-[#8A968D]" stroke-width="1.5" />

            </a>

        </div>

    </div>

</aside>
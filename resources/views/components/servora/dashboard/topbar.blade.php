<header class="sticky top-0 z-30 border-b border-[#DCE5DC] bg-white/90 backdrop-blur">

    <div class="flex h-20 items-center justify-between px-6 lg:px-8">

        {{-- Mobile brand --}}
        <div class="flex items-center gap-3 lg:hidden">

            <button type="button"
                class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#DCE5DC] text-[#294936]">
                <x-tabler-menu-2 class="h-5 w-5" />
            </button>

            <span class="text-sm font-semibold tracking-[0.16em] text-[#294936]">
                SERVORA
            </span>

        </div>


        {{-- Page context --}}
        <div class="hidden lg:block">

            <p class="text-xs font-medium uppercase tracking-[0.16em] text-[#8FA58B]">
                Workspace
            </p>

            <h1 class="mt-1 text-lg font-semibold text-[#183524]">
                Dashboard
            </h1>

        </div>


        {{-- Actions --}}
        <div class="ml-auto flex items-center gap-3">

            <a href="#"
                class="hidden items-center gap-2 rounded-full border border-[#DCE5DC] bg-white px-4 py-2 text-sm font-medium text-[#294936] transition hover:bg-[#F8FAF6] sm:inline-flex">
                <x-tabler-eye class="h-4 w-4" />
                View site
            </a>

            <button type="button"
                class="relative flex h-10 w-10 items-center justify-center rounded-full border border-[#DCE5DC] bg-white text-[#718076] transition hover:bg-[#F8FAF6] hover:text-[#294936]">
                <x-tabler-bell class="h-5 w-5" />

                <span class="absolute right-2 top-2 h-1.5 w-1.5 rounded-full bg-[#5E8067]"></span>
            </button>

        </div>

    </div>

</header>
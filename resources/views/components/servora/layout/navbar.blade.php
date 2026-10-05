<header x-data="{ open: false }" class="sticky top-0 z-50 border-b border-[#DCE5DC]/80 bg-white/95 backdrop-blur">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">

            {{-- Brand --}}
            <a href="#" class="group flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#294936] text-[#F3F7F1]">
                    <x-tabler-leaf class="h-5 w-5" stroke-width="1.7" />
                </div>

                <div>
                    <span class="block text-lg font-semibold tracking-[0.18em] text-[#183524]">
                        SERVORA
                    </span>

                    <span class="hidden text-[10px] uppercase tracking-[0.2em] text-[#718076] sm:block">
                        Gather · Dine · Belong
                    </span>
                </div>
            </a>

            {{-- Desktop navigation --}}
            <nav class="hidden items-center gap-8 md:flex">
                <a href="#" class="text-sm font-medium text-[#26342A] transition hover:text-[#5E8067]">
                    Home
                </a>

                <a href="#" class="text-sm font-medium text-[#718076] transition hover:text-[#294936]">
                    Menu
                </a>

                <a href="#" class="text-sm font-medium text-[#718076] transition hover:text-[#294936]">
                    Events
                </a>

                <a href="#" class="text-sm font-medium text-[#718076] transition hover:text-[#294936]">
                    Reviews
                </a>

                <a href="#"
                    class="rounded-full bg-[#294936] px-5 py-2.5 text-sm font-medium text-white transition hover:bg-[#183524]">
                    Reserve a Table
                </a>
            </nav>

            {{-- Mobile button --}}
            <button type="button" @click="open = !open"
                class="flex h-10 w-10 items-center justify-center rounded-full border border-[#DCE5DC] text-[#294936] md:hidden">
                <x-tabler-menu x-show="!open" class="h-5 w-5" />
                <x-tabler-x x-show="open" class="h-5 w-5" />
            </button>
        </div>

        {{-- Mobile navigation --}}
        <div x-show="open" x-collapse class="border-t border-[#DCE5DC] py-5 md:hidden">
            <nav class="flex flex-col gap-1">

                <a href="#" class="rounded-lg px-4 py-3 text-sm font-medium text-[#294936] hover:bg-[#E8F0E5]">
                    Home
                </a>

                <a href="#" class="rounded-lg px-4 py-3 text-sm text-[#718076] hover:bg-[#E8F0E5]">
                    Menu
                </a>

                <a href="#" class="rounded-lg px-4 py-3 text-sm text-[#718076] hover:bg-[#E8F0E5]">
                    Events
                </a>

                <a href="#" class="rounded-lg px-4 py-3 text-sm text-[#718076] hover:bg-[#E8F0E5]">
                    Reviews
                </a>

                <a href="#" class="mt-2 rounded-full bg-[#294936] px-5 py-3 text-center text-sm font-medium text-white">
                    Reserve a Table
                </a>

            </nav>
        </div>
    </div>
</header>
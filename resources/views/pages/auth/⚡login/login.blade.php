<div class="min-h-[calc(100vh)] bg-[#F8FAF6]">

    <div class="mx-auto flex min-h-[calc(100vh-81px)] max-w-md items-center px-6 py-16">

        <div class="w-full">

            {{-- Brand --}}
            <div class="text-center">

                <a href="#"
                    class="inline-flex items-center gap-2 text-lg font-semibold tracking-[0.18em] text-[#294936]">
                    <x-tabler-leaf class="h-5 w-5 text-[#5E8067]" stroke-width="1.5" />

                    SERVORA
                </a>

                <p class="mt-8 text-xs font-semibold uppercase tracking-[0.22em] text-[#8FA58B]">
                    Welcome back
                </p>

                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-[#183524]">
                    Sign in to Servora
                </h1>

                <p class="mx-auto mt-3 max-w-sm text-sm leading-6 text-[#718076]">
                    Manage your restaurant, reservations, events, and more.
                </p>

            </div>


            {{-- Login card --}}
            <div class="mt-10 rounded-3xl border border-[#DCE5DC] bg-white p-7 shadow-sm sm:p-9">

                <form wire:submit="login" class="space-y-6">

                    {{-- Email --}}
                    <div>

                        <label for="email" class="text-sm font-medium text-[#294936]">
                            Email address
                        </label>

                        <div class="relative mt-2">

                            <x-tabler-mail
                                class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA58B]"
                                stroke-width="1.5" />

                            <input id="email" type="email" wire:model="email" autocomplete="email"
                                placeholder="you@example.com"
                                class="w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] py-3.5 pl-11 pr-4 text-sm text-[#26342A] outline-none transition placeholder:text-[#A1ACA3] focus:border-[#8FA58B] focus:bg-white focus:ring-2 focus:ring-[#E8F0E5]" />

                        </div>

                        @error('email')
                            <p class="mt-2 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Password --}}
                    <div>

                        <div class="flex items-center justify-between">

                            <label for="password" class="text-sm font-medium text-[#294936]">
                                Password
                            </label>

                            <a href="#" class="text-xs font-medium text-[#5E8067] transition hover:text-[#294936]">
                                Forgot password?
                            </a>

                        </div>

                        <div class="relative mt-2">

                            <x-tabler-lock
                                class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA58B]"
                                stroke-width="1.5" />

                            <input id="password" type="password" wire:model="password" autocomplete="current-password"
                                placeholder="Enter your password"
                                class="w-full rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] py-3.5 pl-11 pr-4 text-sm text-[#26342A] outline-none transition placeholder:text-[#A1ACA3] focus:border-[#8FA58B] focus:bg-white focus:ring-2 focus:ring-[#E8F0E5]" />

                        </div>

                        @error('password')
                            <p class="mt-2 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Remember --}}
                    <label class="flex cursor-pointer items-center gap-3">

                        <input type="checkbox" wire:model="remember"
                            class="h-4 w-4 rounded border-[#C8D8C9] text-[#294936] focus:ring-[#8FA58B]">

                        <span class="text-sm text-[#718076]">
                            Remember me
                        </span>

                    </label>


                    {{-- Submit --}}
                    <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-full bg-[#294936] px-6 py-3.5 text-sm font-medium text-white transition hover:bg-[#183524] disabled:cursor-not-allowed disabled:opacity-60"
                        wire:loading.attr="disabled">

                        <span wire:loading.remove>
                            Sign in
                        </span>

                        <span wire:loading class="inline-flex items-center gap-2">
                            <x-tabler-loader-2 class="h-4 w-4 animate-spin" stroke-width="1.5" />

                            Signing in...
                        </span>

                        <x-tabler-arrow-right wire:loading.remove class="h-4 w-4" />

                    </button>

                </form>

            </div>


            {{-- Back to site --}}
            <div class="mt-8 text-center">

                <a href="#"
                    class="inline-flex items-center gap-2 text-sm font-medium text-[#718076] transition hover:text-[#294936]">
                    <x-tabler-arrow-left class="h-4 w-4" />

                    Back to Servora
                </a>

            </div>

        </div>

    </div>

</div>
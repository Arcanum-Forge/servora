<div>

    {{-- Hero --}}
    <section class="bg-white">

        <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-28">

            <div class="mx-auto max-w-3xl text-center">

                <div class="mb-5 flex items-center justify-center gap-3">

                    <span class="h-px w-8 bg-[#8FA58B]"></span>

                    <span class="text-xs font-semibold uppercase tracking-[0.22em] text-[#5E8067]">
                        From our guests
                    </span>

                    <span class="h-px w-8 bg-[#8FA58B]"></span>

                </div>

                <h1 class="text-4xl font-semibold tracking-[-0.035em] text-[#183524] sm:text-5xl lg:text-6xl">
                    Good food is better shared.
                </h1>

                <p class="mx-auto mt-6 max-w-2xl text-base leading-7 text-[#718076] sm:text-lg">
                    Stories from guests who have gathered around our tables,
                    celebrated something special, or simply stayed for one
                    more course.
                </p>

            </div>

        </div>

    </section>


    {{-- Guest sentiment --}}
    <section class="border-y border-[#DCE5DC] bg-[#F8FAF6]">

        <div class="mx-auto max-w-5xl px-6 py-14 lg:px-8">

            <div class="grid gap-10 sm:grid-cols-3 sm:divide-x sm:divide-[#DCE5DC]">

                <div class="text-center">

                    <div class="flex items-center justify-center gap-1 text-[#5E8067]">

                        @for ($i = 0; $i < 5; $i++)
                            <x-tabler-star
                                class="h-4 w-4 fill-current"
                                stroke-width="1.4"
                            />
                        @endfor

                    </div>

                    <p class="mt-4 text-2xl font-semibold text-[#294936]">
                        4.9
                    </p>

                    <p class="mt-1 text-xs uppercase tracking-[0.16em] text-[#8FA58B]">
                        Guest rating
                    </p>

                </div>


                <div class="text-center">

                    <p class="text-2xl font-semibold text-[#294936]">
                        2,400+
                    </p>

                    <p class="mt-1 text-xs uppercase tracking-[0.16em] text-[#8FA58B]">
                        Gatherings shared
                    </p>

                </div>


                <div class="text-center">

                    <p class="text-2xl font-semibold text-[#294936]">
                        84
                    </p>

                    <p class="mt-1 text-xs uppercase tracking-[0.16em] text-[#8FA58B]">
                        Seasonal dishes
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- Featured review --}}
    <section class="bg-white">

        <div class="mx-auto max-w-5xl px-6 py-20 lg:px-8 lg:py-24">

            <div class="relative overflow-hidden rounded-[2rem] bg-[#294936] p-8 sm:p-12 lg:p-16">

                <x-tabler-quote
                    class="absolute right-8 top-8 h-20 w-20 text-[#45664F] sm:right-12 sm:top-12"
                    stroke-width="1"
                />

                <div class="relative max-w-3xl">

                    <div class="flex gap-1 text-[#C5D6C5]">

                        @for ($i = 0; $i < 5; $i++)
                            <x-tabler-star
                                class="h-4 w-4 fill-current"
                                stroke-width="1.4"
                            />
                        @endfor

                    </div>

                    <blockquote class="mt-7 text-2xl font-medium leading-9 tracking-tight text-white sm:text-3xl sm:leading-10">
                        “We came for dinner and ended up staying for
                        stories, music, and another bottle of moonwine.
                        It felt less like eating out and more like being
                        welcomed into someone's home.”
                    </blockquote>

                    <div class="mt-8 flex items-center gap-4">

                        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#E8F0E5] text-sm font-semibold text-[#294936]">
                            E
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-white">
                                Elira Vane
                            </p>

                            <p class="mt-1 text-xs text-[#B8CDB8]">
                                Valoria · Evening of Bards
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- Reviews --}}
    <section class="border-t border-[#DCE5DC] bg-[#F8FAF6]">

        <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-24">

            <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-end">

                <div>

                    <div class="mb-4 flex items-center gap-3">

                        <span class="h-px w-8 bg-[#8FA58B]"></span>

                        <span class="text-xs font-semibold uppercase tracking-[0.22em] text-[#5E8067]">
                            Guest book
                        </span>

                    </div>

                    <h2 class="text-3xl font-semibold tracking-tight text-[#183524] sm:text-4xl">
                        Kind words from the table.
                    </h2>

                </div>

                <p class="max-w-sm text-sm leading-6 text-[#718076]">
                    A few notes left behind by guests from across the realm.
                </p>

            </div>


            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">

                {{-- Review --}}
                <article class="rounded-2xl border border-[#DCE5DC] bg-white p-7">

                    <div class="flex gap-1 text-[#5E8067]">

                        @for ($i = 0; $i < 5; $i++)
                            <x-tabler-star
                                class="h-4 w-4 fill-current"
                                stroke-width="1.4"
                            />
                        @endfor

                    </div>

                    <p class="mt-6 text-sm leading-7 text-[#26342A]">
                        “The Dragonfire Roast was incredible. The fireberry
                        glaze was just sweet enough, and the whole table
                        ended up ordering another round of bread.”
                    </p>

                    <div class="mt-7 border-t border-[#DCE5DC] pt-5">

                        <p class="text-sm font-semibold text-[#294936]">
                            Rowan Hale
                        </p>

                        <p class="mt-1 text-xs text-[#8FA58B]">
                            Crown District · Valoria
                        </p>

                    </div>

                </article>


                {{-- Review --}}
                <article class="rounded-2xl border border-[#DCE5DC] bg-white p-7">

                    <div class="flex gap-1 text-[#5E8067]">

                        @for ($i = 0; $i < 5; $i++)
                            <x-tabler-star
                                class="h-4 w-4 fill-current"
                                stroke-width="1.4"
                            />
                        @endfor

                    </div>

                    <p class="mt-6 text-sm leading-7 text-[#26342A]">
                        “A beautiful place for a long evening. We ordered
                        the Moonroot Stew, shared a tart, and completely
                        lost track of time.”
                    </p>

                    <div class="mt-7 border-t border-[#DCE5DC] pt-5">

                        <p class="text-sm font-semibold text-[#294936]">
                            Mira Solen
                        </p>

                        <p class="mt-1 text-xs text-[#8FA58B]">
                            Riverside · Eldermere
                        </p>

                    </div>

                </article>


                {{-- Review --}}
                <article class="rounded-2xl border border-[#DCE5DC] bg-white p-7">

                    <div class="flex gap-1 text-[#5E8067]">

                        @for ($i = 0; $i < 5; $i++)
                            <x-tabler-star
                                class="h-4 w-4 fill-current"
                                stroke-width="1.4"
                            />
                        @endfor

                    </div>

                    <p class="mt-6 text-sm leading-7 text-[#26342A]">
                        “The staff made our anniversary feel genuinely
                        special. Wonderful food, thoughtful service, and
                        the best Moonwine we've had in years.”
                    </p>

                    <div class="mt-7 border-t border-[#DCE5DC] pt-5">

                        <p class="text-sm font-semibold text-[#294936]">
                            Taren & Lyra
                        </p>

                        <p class="mt-1 text-xs text-[#8FA58B]">
                            Old Quarter · Aurelia
                        </p>

                    </div>

                </article>


                {{-- Review --}}
                <article class="rounded-2xl border border-[#DCE5DC] bg-white p-7">

                    <div class="flex gap-1 text-[#5E8067]">

                        @for ($i = 0; $i < 5; $i++)
                            <x-tabler-star
                                class="h-4 w-4 fill-current"
                                stroke-width="1.4"
                            />
                        @endfor

                    </div>

                    <p class="mt-6 text-sm leading-7 text-[#26342A]">
                        “We brought the whole guild after a long journey.
                        Plenty of food, generous portions, and a table
                        large enough for everyone.”
                    </p>

                    <div class="mt-7 border-t border-[#DCE5DC] pt-5">

                        <p class="text-sm font-semibold text-[#294936]">
                            Captain Orin
                        </p>

                        <p class="mt-1 text-xs text-[#8FA58B]">
                            North Road · Valoria
                        </p>

                    </div>

                </article>


                {{-- Review --}}
                <article class="rounded-2xl border border-[#DCE5DC] bg-white p-7">

                    <div class="flex gap-1 text-[#5E8067]">

                        @for ($i = 0; $i < 5; $i++)
                            <x-tabler-star
                                class="h-4 w-4 fill-current"
                                stroke-width="1.4"
                            />
                        @endfor

                    </div>

                    <p class="mt-6 text-sm leading-7 text-[#26342A]">
                        “The Harvest Table was exactly what we needed after
                        a long autumn road. Warm bread, good wine, and
                        strangers who quickly became friends.”
                    </p>

                    <div class="mt-7 border-t border-[#DCE5DC] pt-5">

                        <p class="text-sm font-semibold text-[#294936]">
                            Sera Windmere
                        </p>

                        <p class="mt-1 text-xs text-[#8FA58B]">
                            Eldermere
                        </p>

                    </div>

                </article>


                {{-- Review --}}
                <article class="rounded-2xl border border-[#DCE5DC] bg-white p-7">

                    <div class="flex gap-1 text-[#5E8067]">

                        @for ($i = 0; $i < 5; $i++)
                            <x-tabler-star
                                class="h-4 w-4 fill-current"
                                stroke-width="1.4"
                            />
                        @endfor

                    </div>

                    <p class="mt-6 text-sm leading-7 text-[#26342A]">
                        “Quiet, elegant, and incredibly welcoming. The
                        perfect place when you want dinner to become an
                        evening rather than just a meal.”
                    </p>

                    <div class="mt-7 border-t border-[#DCE5DC] pt-5">

                        <p class="text-sm font-semibold text-[#294936]">
                            Arwen Vale
                        </p>

                        <p class="mt-1 text-xs text-[#8FA58B]">
                            Old Quarter · Aurelia
                        </p>

                    </div>

                </article>

            </div>

        </div>

    </section>


    {{-- What guests love --}}
    <section class="bg-white">

        <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-24">

            <div class="mx-auto max-w-2xl text-center">

                <div class="mb-4 flex items-center justify-center gap-3">

                    <span class="h-px w-8 bg-[#8FA58B]"></span>

                    <span class="text-xs font-semibold uppercase tracking-[0.22em] text-[#5E8067]">
                        Around the table
                    </span>

                    <span class="h-px w-8 bg-[#8FA58B]"></span>

                </div>

                <h2 class="text-3xl font-semibold tracking-tight text-[#183524] sm:text-4xl">
                    What brings people back.
                </h2>

            </div>


            <div class="mt-14 grid gap-8 md:grid-cols-3">

                <div class="text-center">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#E8F0E5]">

                        <x-tabler-tools-kitchen-2
                            class="h-6 w-6 text-[#5E8067]"
                            stroke-width="1.4"
                        />

                    </div>

                    <h3 class="mt-5 text-lg font-semibold text-[#294936]">
                        Seasonal food
                    </h3>

                    <p class="mx-auto mt-3 max-w-xs text-sm leading-6 text-[#718076]">
                        Menus that change with the seasons and the ingredients
                        available around us.
                    </p>

                </div>


                <div class="text-center">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#E8F0E5]">

                        <x-tabler-heart
                            class="h-6 w-6 text-[#5E8067]"
                            stroke-width="1.4"
                        />

                    </div>

                    <h3 class="mt-5 text-lg font-semibold text-[#294936]">
                        Thoughtful service
                    </h3>

                    <p class="mx-auto mt-3 max-w-xs text-sm leading-6 text-[#718076]">
                        Warm hospitality that makes a meal feel personal
                        without getting in the way.
                    </p>

                </div>


                <div class="text-center">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[#E8F0E5]">

                        <x-tabler-users
                            class="h-6 w-6 text-[#5E8067]"
                            stroke-width="1.4"
                        />

                    </div>

                    <h3 class="mt-5 text-lg font-semibold text-[#294936]">
                        A place to gather
                    </h3>

                    <p class="mx-auto mt-3 max-w-xs text-sm leading-6 text-[#718076]">
                        Tables made for celebrations, conversations, and
                        lingering a little longer.
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- CTA --}}
    <section class="border-t border-[#DCE5DC] bg-[#F8FAF6]">

        <div class="mx-auto max-w-3xl px-6 py-20 text-center lg:px-8 lg:py-24">

            <x-tabler-calendar-heart
                class="mx-auto h-7 w-7 text-[#8FA58B]"
                stroke-width="1.3"
            />

            <h2 class="mt-5 text-3xl font-semibold tracking-tight text-[#183524] sm:text-4xl">
                Make your own memories.
            </h2>

            <p class="mx-auto mt-4 max-w-xl text-base leading-7 text-[#718076]">
                Come hungry, bring good company, and leave with a story
                worth telling.
            </p>

            <a
                href="#"
                class="mt-8 inline-flex items-center gap-2 rounded-full bg-[#294936] px-7 py-3.5 text-sm font-medium text-white transition hover:bg-[#183524]"
            >
                Reserve a Table

                <x-tabler-calendar-heart class="h-4 w-4" />
            </a>

        </div>

    </section>

</div>
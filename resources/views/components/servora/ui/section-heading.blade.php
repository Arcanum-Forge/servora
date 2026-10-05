@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'centered' => true,
])

<div class="{{ $centered ? 'mx-auto text-center' : '' }} max-w-2xl">

    @if ($eyebrow)
        <div class="mb-4 flex items-center gap-3 {{ $centered ? 'justify-center' : '' }}">
            <span class="h-px w-8 bg-[#8FA58B]"></span>

            <span class="text-xs font-semibold uppercase tracking-[0.22em] text-[#5E8067]">
                {{ $eyebrow }}
            </span>

            <span class="h-px w-8 bg-[#8FA58B]"></span>
        </div>
    @endif

    <h2 class="text-3xl font-semibold tracking-tight text-[#183524] sm:text-4xl lg:text-5xl">
        {{ $title }}
    </h2>

    @if ($description)
        <p class="mt-5 text-base leading-7 text-[#718076] sm:text-lg">
            {{ $description }}
        </p>
    @endif
</div>
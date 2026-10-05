@props(['on' => false])

<button type="button" role="switch" aria-checked="{{ $on ? 'true' : 'false' }}" {{ $attributes->merge(['class' => 'relative h-6 w-11 shrink-0 rounded-full transition ' . ($on ? 'bg-[#5E8067]' : 'bg-[#C9D1CB]')]) }}>
    <span
        class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition-all {{ $on ? 'left-[22px]' : 'left-0.5' }}"></span>
</button>
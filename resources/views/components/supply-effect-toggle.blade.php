@props(['impact'])

<div class="inline-flex rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] p-0.5 text-xs font-medium">
    @foreach (['limited' => 'Limited', 'unavailable' => 'Unavailable'] as $effect => $effectLabel)
        <button type="button" wire:key="effect-{{ $impact->id }}-{{ $effect }}"
            wire:click="setImpactEffect({{ $impact->id }}, '{{ $effect }}')"
            class="rounded-lg px-3 py-1.5 transition
                {{ $impact->effect === $effect
                    ? ($effect === 'unavailable' ? 'bg-[#B94A48] text-white' : 'bg-[#9A762B] text-white')
                    : 'text-[#718076] hover:text-[#294936]' }}">
            {{ $effectLabel }}
        </button>
    @endforeach
</div>
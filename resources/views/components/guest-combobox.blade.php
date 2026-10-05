@props([
    'model',
    'target' => 'reservation',
    'value' => '',
    'suggestions' => null,
    'selected' => null,
    'label' => 'Guest',
    'placeholder' => 'Search a guest or type a new name…',
])

@php($suggestions = $suggestions ?? collect())

<div class="relative">

    <label class="text-xs font-medium text-[#718076]">{{ $label }}</label>

    <div class="relative mt-1">
        <x-tabler-search class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#8FA58B]" />
        <input type="text" wire:model.live.debounce.250ms="{{ $model }}" placeholder="{{ $placeholder }}"
            autocomplete="off" autofocus
            class="w-full rounded-xl border border-[#DCE5DC] py-2.5 pl-9 pr-3 text-sm text-[#294936] focus:border-[#5E8067] focus:outline-none focus:ring-1 focus:ring-[#5E8067]">
    </div>

    @if ($selected)

        <div class="mt-2 flex items-center justify-between gap-3 rounded-xl bg-[#E8F0E5] px-3 py-2">
            <div class="flex min-w-0 items-center gap-2 text-xs text-[#294936]">
                <x-tabler-user-check class="h-4 w-4 shrink-0 text-[#5E8067]" />
                <span class="truncate">
                    Existing guest
                    @if ($selected->phone) · {{ $selected->phone }} @endif
                    · {{ $selected->reservations_count }} {{ $selected->reservations_count === 1 ? 'visit' : 'visits' }}
                </span>
            </div>
            <button type="button" wire:click="clearGuest('{{ $target }}')"
                class="shrink-0 text-xs font-medium text-[#5E8067] underline hover:text-[#294936]">
                Change
            </button>
        </div>

    @elseif ($suggestions->isNotEmpty())

        <div
            class="absolute left-0 right-0 z-20 mt-1 overflow-hidden rounded-xl border border-[#DCE5DC] bg-white shadow-lg">
            @foreach ($suggestions as $guest)
                <button type="button" wire:key="guest-suggestion-{{ $target }}-{{ $guest->id }}"
                    wire:click="pickGuest({{ $guest->id }}, '{{ $target }}')"
                    class="flex w-full items-center justify-between gap-3 px-3 py-2.5 text-left transition hover:bg-[#F8FAF6]">
                    <span class="min-w-0">
                        <span class="block truncate text-sm font-medium text-[#183524]">{{ $guest->name }}</span>
                        <span
                            class="block truncate text-xs text-[#8FA58B]">{{ $guest->phone ?? $guest->email ?? 'No contact info' }}</span>
                    </span>
                    <span class="shrink-0 rounded-full bg-[#F0F3EF] px-2 py-0.5 text-[10px] font-semibold text-[#718076]">
                        {{ $guest->reservations_count }} {{ $guest->reservations_count === 1 ? 'visit' : 'visits' }}
                    </span>
                </button>
            @endforeach
            <p class="border-t border-[#F0F3EF] bg-[#F8FAF6] px-3 py-2 text-[11px] text-[#8FA58B]">
                Keep typing to add "{{ $value }}" as a new guest.
            </p>
        </div>

    @elseif (trim($value) !== '')

        <p class="mt-2 flex items-center gap-1.5 text-xs text-[#8FA58B]">
            <x-tabler-user-plus class="h-3.5 w-3.5" />
            New guest — they'll be added to your directory.
        </p>

    @endif

</div>
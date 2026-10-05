@props([
    'tables',
    'elements' => null,
    'selected' => null,
    'model',
    'disableUnavailable' => false,
])

@php
$elements = $elements ?? collect();
@endphp

<div>

    <div class="overflow-x-auto rounded-xl border border-[#DCE5DC] bg-[#F8FAF6] p-3">
        <div class="relative mx-auto" style="width: 960px; min-height: 680px;">

            <div class="pointer-events-none absolute inset-6 rounded-3xl border border-[#DCE5DC]"></div>

            {{-- Barriers: context only, not clickable --}}
            @foreach ($elements->where('type', \App\Enums\FloorElementType::Barrier) as $element)
                @php
                    $preset = $element->preset ?? \App\Enums\FloorElementPreset::Wall;
                    $icon = $preset->icon();
                    $accent = $preset->accentColor();
                @endphp
                <div style="position: absolute; left: {{ $element->pos_x }}px; top: {{ $element->pos_y }}px; width: {{ $element->width }}px; height: {{ $element->height }}px;">
                    <div style="transform: rotate({{ $element->rotation }}deg); {{ $icon ? 'border-color: '.$accent.'; background-color: '.$accent.'1A; color: '.$accent.';' : '' }}"
                        class="flex h-full w-full origin-center flex-col items-center justify-center gap-1 overflow-hidden border-2 px-2 text-center text-[10px] font-medium uppercase tracking-wide {{ $icon ? '' : 'border-dashed border-[#718076]/50 bg-[#718076]/15 text-[#718076]' }} {{ $element->shape->radiusClass() }}">
                        @if ($icon)
                            <x-dynamic-component :component="'tabler-'.$icon" class="h-4 w-4 shrink-0" />
                        @endif
                        <span class="truncate leading-tight">{{ $element->name ?: $preset->label() }}</span>
                    </div>
                </div>
            @endforeach

            {{-- Labels: context only --}}
            @foreach ($elements->where('type', \App\Enums\FloorElementType::Label) as $element)
                <div style="position: absolute; left: {{ $element->pos_x }}px; top: {{ $element->pos_y }}px; width: {{ $element->width }}px; height: {{ $element->height }}px;">
                    <div style="transform: rotate({{ $element->rotation }}deg);"
                        class="flex h-full w-full origin-center items-center justify-center rounded-lg px-2 text-xs font-semibold uppercase tracking-wide text-[#294936]">
                        {{ $element->name }}
                    </div>
                </div>
            @endforeach

            {{-- Tables: the actual picker --}}
            @foreach ($tables as $table)
                @php
                    $isSelected = $selected && (int) $selected === $table->id;
                    $isDisabled = $disableUnavailable && $table->status->value !== 'available' && ! $isSelected;
                @endphp
                <div style="position: absolute; left: {{ $table->pos_x ?? 40 }}px; top: {{ $table->pos_y ?? 40 }}px; width: {{ $table->width }}px; height: {{ $table->height }}px;">
                    <button type="button"
                        @unless ($isDisabled) wire:click="$set('{{ $model }}', {{ $table->id }})" @endunless
                        @disabled($isDisabled)
                        style="transform: rotate({{ $table->rotation }}deg);"
                        class="group relative flex h-full w-full origin-center flex-col items-center justify-center border-2 bg-white shadow-sm transition {{ $table->shape->radiusClass() }}
                                {{ $isSelected ? 'border-[#294936] ring-2 ring-[#294936] ring-offset-2 ring-offset-[#F8FAF6]' : $table->status->borderColor() }}
                                {{ $isDisabled ? 'cursor-not-allowed opacity-40' : 'cursor-pointer hover:-translate-y-1 hover:shadow-md' }}">

                        <span class="text-sm font-semibold text-[#294936]">{{ $table->name }}</span>
                        <span class="mt-1 text-[10px] uppercase tracking-wider text-[#8FA58B]">{{ $table->seatsLabel }}</span>
                        <span class="absolute -right-1.5 -top-1.5 h-3 w-3 rounded-full {{ $table->status->dotColor() }} ring-2 ring-white"></span>

                        @if ($isSelected)
                            <span class="absolute -left-1.5 -top-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-[#294936] text-white">
                                <x-tabler-check class="h-3 w-3" />
                            </span>
                        @endif
                    </button>
                </div>
            @endforeach

        </div>
    </div>

    <div class="mt-2 flex flex-wrap items-center gap-4 text-xs text-[#718076]">
        @foreach (\App\Enums\TableStatus::cases() as $status)
            <div class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full {{ $status->dotColor() }}"></span>
                {{ $status->label() }}
            </div>
        @endforeach
        @if ($disableUnavailable)
            <span class="text-[#8FA58B]">· greyed-out tables are already occupied or reserved</span>
        @endif
    </div>

</div>
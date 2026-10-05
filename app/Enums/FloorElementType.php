<?php

namespace App\Enums;

enum FloorElementType: string
{
    case Barrier = 'barrier';
    case Label = 'label';

    public function label(): string
    {
        return match ($this) {
            self::Barrier => 'Barrier',
            self::Label => 'Label',
        };
    }
}
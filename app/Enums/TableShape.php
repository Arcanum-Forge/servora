<?php

namespace App\Enums;

enum TableShape: string
{
    case Rectangle = 'rectangle';
    case Round = 'round';

    public function label(): string
    {
        return match ($this) {
            self::Rectangle => 'Rectangle',
            self::Round => 'Round',
        };
    }

    public function radiusClass(): string
    {
        return match ($this) {
            self::Rectangle => 'rounded-xl',
            self::Round => 'rounded-full',
        };
    }
}
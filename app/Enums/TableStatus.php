<?php

namespace App\Enums;

enum TableStatus: string
{
    case Available = 'available';
    case Reserved = 'reserved';
    case Occupied = 'occupied';

    public function label(): string
    {
        return match ($this) {
            self::Available => 'Available',
            self::Reserved => 'Reserved',
            self::Occupied => 'Occupied',
        };
    }

    public function dotColor(): string
    {
        return match ($this) {
            self::Available => 'bg-[#5E8067]',
            self::Reserved => 'bg-[#9A762B]',
            self::Occupied => 'bg-[#B94A48]',
        };
    }

    public function textColor(): string
    {
        return match ($this) {
            self::Available => 'text-[#5E8067]',
            self::Reserved => 'text-[#9A762B]',
            self::Occupied => 'text-[#B94A48]',
        };
    }

    public function borderColor(): string
    {
        return match ($this) {
            self::Available => 'border-[#C8D8C9] hover:border-[#5E8067]',
            self::Reserved => 'border-[#D8CDBD] hover:border-[#9A762B]',
            self::Occupied => 'border-[#E0BDBA] hover:border-[#B94A48]',
        };
    }
}
<?php

namespace App\Enums;

enum ReservationStatus: string
{
    case Confirmed = 'confirmed';
    case Seated = 'seated';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case NoShow = 'no_show';

    public function label(): string
    {
        return match ($this) {
            self::Confirmed => 'Confirmed',
            self::Seated => 'Seated',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
            self::NoShow => 'No-show',
        };
    }

    public function textColor(): string
    {
        return match ($this) {
            self::Confirmed => 'text-[#5E8067]',
            self::Seated => 'text-[#294936]',
            self::Completed => 'text-[#718076]',
            self::Cancelled => 'text-[#B94A48]',
            self::NoShow => 'text-[#B94A48]',
        };
    }

    public function bgColor(): string
    {
        return match ($this) {
            self::Confirmed => 'bg-[#E8F0E5]',
            self::Seated => 'bg-[#E8F0E5]',
            self::Completed => 'bg-[#F0F3EF]',
            self::Cancelled => 'bg-[#FBEAEA]',
            self::NoShow => 'bg-[#FBEAEA]',
        };
    }

    public function iconBg(): string
    {
        return match ($this) {
            self::Confirmed => 'bg-[#E8F0E5]',
            self::Seated => 'bg-[#294936]',
            self::Completed => 'bg-[#F0F3EF]',
            self::Cancelled, self::NoShow => 'bg-[#FBEAEA]',
        };
    }
}
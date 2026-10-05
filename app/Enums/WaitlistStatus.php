<?php

namespace App\Enums;

enum WaitlistStatus: string
{
    case Waiting = 'waiting';
    case Seated = 'seated';
    case Left = 'left';

    public function label(): string
    {
        return match ($this) {
            self::Waiting => 'Waiting',
            self::Seated => 'Seated',
            self::Left => 'Left',
        };
    }
}
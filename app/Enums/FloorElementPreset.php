<?php

namespace App\Enums;

enum FloorElementPreset: string
{
    case Wall = 'wall';
    case BarCounter = 'bar_counter';
    case KitchenDoor = 'kitchen_door';
    case Restroom = 'restroom';
    case HostStand = 'host_stand';
    case Stairs = 'stairs';
    case Plant = 'plant';
    case Custom = 'custom';

    public function label(): string
    {
        return match ($this) {
            self::Wall => 'Wall',
            self::BarCounter => 'Bar Counter',
            self::KitchenDoor => 'Kitchen Door',
            self::Restroom => 'Restroom',
            self::HostStand => 'Host Stand',
            self::Stairs => 'Stairs',
            self::Plant => 'Plant',
            self::Custom => 'Custom',
        };
    }

    /**
     * Tabler icon name, or null for the plain dashed-box look (Wall/Custom).
     */
    public function icon(): ?string
    {
        return match ($this) {
            self::BarCounter => 'beer',
            self::KitchenDoor => 'door',
            self::Restroom => 'toilet-paper',
            self::HostStand => 'clipboard-list',
            self::Stairs => 'stairs',
            self::Plant => 'plant',
            default => null,
        };
    }

    public function accentColor(): string
    {
        return match ($this) {
            self::BarCounter => '#9A762B',
            self::KitchenDoor => '#B94A48',
            self::Restroom => '#47708F',
            self::HostStand => '#5E8067',
            self::Stairs => '#718076',
            self::Plant => '#5E8067',
            default => '#718076',
        };
    }

    public function defaultWidth(): int
    {
        return match ($this) {
            self::Wall => 160,
            self::BarCounter => 220,
            self::KitchenDoor, self::Restroom, self::HostStand => 72,
            self::Stairs => 96,
            self::Plant => 48,
            self::Custom => 160,
        };
    }

    public function defaultHeight(): int
    {
        return match ($this) {
            self::Wall => 24,
            self::BarCounter => 48,
            self::KitchenDoor, self::Restroom, self::HostStand => 72,
            self::Stairs => 96,
            self::Plant => 48,
            self::Custom => 24,
        };
    }
}
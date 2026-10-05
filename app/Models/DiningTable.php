<?php

namespace App\Models;

use App\Enums\TableShape;
use App\Enums\TableStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiningTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'dining_hall_id',
        'table_section_id',
        'name',
        'seats',
        'status',
        'shape',
        'rotation',
        'pos_x',
        'pos_y',
        'width',
        'height',
        'is_featured',
    ];

    protected $casts = [
        'status' => TableStatus::class,
        'shape' => TableShape::class,
        'is_featured' => 'boolean',
    ];

    public function hall(): BelongsTo
    {
        return $this->belongsTo(DiningHall::class, 'dining_hall_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(TableSection::class, 'table_section_id');
    }

    public function reservations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', TableStatus::Available);
    }

    public function scopeReserved($query)
    {
        return $query->where('status', TableStatus::Reserved);
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', TableStatus::Occupied);
    }

    protected function seatsLabel(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn() => $this->seats . ' ' . \Illuminate\Support\Str::plural('seat', $this->seats),
        );
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
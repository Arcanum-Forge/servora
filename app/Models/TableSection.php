<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TableSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'dining_hall_id',
        'name',
        'color',
        'sort_order',
    ];

    public function hall(): BelongsTo
    {
        return $this->belongsTo(DiningHall::class, 'dining_hall_id');
    }

    public function tables(): HasMany
    {
        return $this->hasMany(DiningTable::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
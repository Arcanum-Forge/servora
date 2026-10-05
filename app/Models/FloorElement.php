<?php

namespace App\Models;

use App\Enums\FloorElementPreset;
use App\Enums\FloorElementType;
use App\Enums\TableShape;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FloorElement extends Model
{
    use HasFactory;

    protected $fillable = [
        'dining_hall_id',
        'type',
        'preset',
        'name',
        'shape',
        'rotation',
        'pos_x',
        'pos_y',
        'width',
        'height',
        'color',
    ];

    protected $casts = [
        'type' => FloorElementType::class,
        'preset' => FloorElementPreset::class,
        'shape' => TableShape::class,
    ];

    public function hall(): BelongsTo
    {
        return $this->belongsTo(DiningHall::class, 'dining_hall_id');
    }

    public function scopeBarriers($query)
    {
        return $query->where('type', FloorElementType::Barrier);
    }

    public function scopeLabels($query)
    {
        return $query->where('type', FloorElementType::Label);
    }
}
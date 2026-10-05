<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shift extends Model
{
    protected $fillable = [
        'employee_id',
        'name',
        'shift_date',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'shift_date' => 'date',
    ];

    protected $appends = ['duration_hours'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    protected function durationHours(): Attribute
    {
        return Attribute::get(function () {
            $start = Carbon::parse($this->start_time);
            $end = Carbon::parse($this->end_time);

            // Handle overnight shifts
            if ($end->lessThan($start)) {
                $end->addDay();
            }

            return round($start->diffInMinutes($end) / 60, 1);
        });
    }
}
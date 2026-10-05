<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'shift_id',
        'date',
        'clocked_in_at',
        'clocked_out_at',
        'hours_worked',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'clocked_in_at' => 'datetime',
        'clocked_out_at' => 'datetime',
        'hours_worked' => 'decimal:2',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }
}
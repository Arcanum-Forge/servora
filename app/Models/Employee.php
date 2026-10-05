<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'department',
        'status',
        'avatar_color',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'date',
    ];

    protected $appends = ['full_name', 'initials'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }

    protected function fullName(): Attribute
    {
        return Attribute::get(fn() => trim("{$this->first_name} {$this->last_name}"));
    }

    protected function initials(): Attribute
    {
        return Attribute::get(fn() => strtoupper(
            mb_substr($this->first_name, 0, 1) . mb_substr($this->last_name, 0, 1)
        ));
    }

    /** @return array{bg: string, text: string} */
    public function avatarClasses(): array
    {
        return match ($this->avatar_color) {
            'tan' => ['bg' => 'bg-[#F1E9DF]', 'text' => 'text-[#7D6048]'],
            'amber' => ['bg' => 'bg-[#FFF4DD]', 'text' => 'text-[#9A762B]'],
            'gray' => ['bg' => 'bg-[#F3F4F1]', 'text' => 'text-[#718076]'],
            default => ['bg' => 'bg-[#E8F0E5]', 'text' => 'text-[#294936]'],
        };
    }
}
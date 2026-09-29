<?php

namespace App\Models;

use Database\Factories\ScheduleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /** @use HasFactory<ScheduleFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->piket_type === 'piket_rayon' ? 'Piket Rayon' : 'Piket WC';
    }

    public function scopePiketWc($query)
    {
        return $query->where('piket_type', 'piket_wc');
    }

    public function scopePiketRayon($query)
    {
        return $query->where('piket_type', 'piket_rayon');
    }

    public function dutyMembers()
    {
        return $this->hasMany(DutyMember::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}

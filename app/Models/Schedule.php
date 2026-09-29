<?php

namespace App\Models;

use Database\Factories\ScheduleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Label teks jenis piket (Piket Rayon / Piket WC).
     */
    public function getTypeLabelAttribute(): string
    {
        return $this->piket_type === 'piket_rayon' ? 'Piket Rayon' : 'Piket WC';
    }

    /**
     * Scope untuk jadwal khusus Piket WC.
     */
    public function scopePiketWc(Builder $query): Builder
    {
        return $query->where('piket_type', 'piket_wc');
    }

    /**
     * Scope untuk jadwal khusus Piket Rayon.
     */
    public function scopePiketRayon(Builder $query): Builder
    {
        return $query->where('piket_type', 'piket_rayon');
    }

    /**
     * Cek apakah seorang user adalah PJ (Penanggung Jawab) pada jadwal ini.
     */
    public function isPj(int $userId): bool
    {
        return $this->dutyMembers()
            ->where('user_id', $userId)
            ->where('is_pj', true)
            ->exists();
    }

    public function dutyMembers(): HasMany
    {
        return $this->hasMany(DutyMember::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}

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

    /**
     * Hitung status jadwal secara dinamis berdasarkan waktu nyata
     */
    public function getEffectiveStatusAttribute(): string
    {
        if ($this->status !== 'belum_dilakukan') {
            return $this->status;
        }

        if (!$this->date) {
            return 'belum_dilakukan';
        }

        $timeString = $this->time ? $this->time : '00:00:00';
        $scheduleDateTime = \Carbon\Carbon::parse($this->date->format('Y-m-d') . ' ' . $timeString);
        $now = now();

        // 1. Jika hari sudah berganti ke besok (waktu habis)
        if ($now->startOfDay()->gt($scheduleDateTime->copy()->startOfDay())) {
            // Cek apakah ada anggota yang laporan (absen)
            $hasAttendance = $this->dutyMembers()->whereHas('attendances')->exists();
            if ($hasAttendance) {
                return 'selesai';
            }
            return 'tidak_terlaksana';
        }

        // 2. Jika hari ini dan waktu jam sudah terlewat (sedang masa piket)
        if ($now->isSameDay($scheduleDateTime) && $now->gte($scheduleDateTime)) {
            return 'sedang_berlangsung';
        }

        // 3. Masih di masa depan
        return 'belum_dilakukan';
    }
}

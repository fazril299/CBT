<?php

namespace App\Models;

use Database\Factories\DutyMemberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DutyMember extends Model
{
    /** @use HasFactory<DutyMemberFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_pj' => 'boolean',
        ];
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class)->orderBy('id', 'desc');
    }

    public function latestAttendance(): HasOne
    {
        return $this->hasOne(Attendance::class)->latestOfMany();
    }

    /**
     * Cek apakah jadwal piket ini masih di masa mendatang (belum hari H).
     */
    public function isScheduleInFuture(): bool
    {
        $schedule = $this->schedule;

        if (! $schedule || ! $schedule->date) {
            return true;
        }

        return $schedule->date->startOfDay()->gt(now()->startOfDay());
    }

    /**
     * Cek apakah jadwal piket adalah hari ini dan belum ditandai selesai.
     */
    public function isTodaySchedulePending(): bool
    {
        $schedule = $this->schedule;

        if (! $schedule || ! $schedule->date) {
            return false;
        }

        $scheduleDate = $schedule->date->startOfDay();
        $today = now()->startOfDay();

        return $scheduleDate->eq($today) && $schedule->status !== 'selesai';
    }

    /**
     * Menghitung status efektif kehadiran anggota secara dinamis:
     * 1. Jika sudah ada data absensi -> gunakan status tersebut (hadir, menunggu_verifikasi, dsb).
     * 2. Jika jadwal di masa depan -> 'belum_waktunya'.
     * 3. Jika jadwal hari ini dan belum selesai -> 'belum_absen'.
     * 4. Jika jadwal sudah lewat tanpa ada absen -> 'alpa'.
     */
    public function getEffectiveStatusAttribute(): string
    {
        $attendance = $this->latestAttendance ?? $this->attendances->first();

        if ($attendance) {
            return $attendance->status;
        }

        if ($this->isScheduleInFuture()) {
            return 'belum_waktunya';
        }

        if ($this->isTodaySchedulePending()) {
            return 'belum_absen';
        }

        return 'alpa';
    }

    /**
     * Label teks yang rapi dan mudah dibaca untuk status efektif anggota.
     */
    public function getEffectiveStatusLabelAttribute(): string
    {
        return match ($this->effective_status) {
            'hadir' => '✓ Hadir (Terverifikasi)',
            'menunggu_verifikasi' => '⏳ Menunggu Verifikasi PJ',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'belum_waktunya' => 'Belum Mulai (Jadwal Mendatang)',
            'belum_absen' => '⏳ Belum Piket / Absen',
            'alpa' => 'Alpa (Denda Rp 5.000)',
            default => 'Belum Absen',
        };
    }
}

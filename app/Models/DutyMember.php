<?php

namespace App\Models;

use Database\Factories\DutyMemberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class)->orderBy('id', 'desc');
    }

    public function latestAttendance()
    {
        return $this->hasOne(Attendance::class)->latestOfMany();
    }

    public function hasRecordedAttendance(): bool
    {
        return $this->latestAttendance !== null || $this->attendances->isNotEmpty();
    }

    public function isScheduleInFuture(): bool
    {
        $schedule = $this->schedule;

        if (! $schedule || ! $schedule->date) {
            return true;
        }

        return $schedule->date->startOfDay()->gt(now()->startOfDay());
    }

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

    public function getDendaAmountAttribute(): int
    {
        return $this->effective_status === 'alpa' ? 5000 : 0;
    }
}

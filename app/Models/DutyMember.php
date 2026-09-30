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
        // 1. Ambil data absen terakhir milik siswa ini dari database
        $attendance = $this->latestAttendance ?? $this->attendances->first();

        // 2. Kalau siswanya sudah pernah klik tombol absen, 
        // maka tampilkan statusnya (misal: 'hadir', 'izin', atau 'sakit')
        if ($attendance) {
            return $attendance->status;
        }

        // 3. Kalau jadwalnya masih BESOK atau MINGGU DEPAN, berarti belum waktunya absen
        if ($this->isScheduleInFuture()) {
            return 'belum_waktunya';
        }

        // 4. Kalau jadwal piketnya adalah HARI INI, berarti statusnya sedang 'belum_absen'
        if ($this->isTodaySchedulePending()) {
            return 'belum_absen';
        }

        // 5. Kalau jadwalnya HARI KEMARIN dan siswa sama sekali tidak ngirim absen (melewati tahap 2)
        // Maka sistem otomatis memvonis siswa tersebut menjadi ALPA
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



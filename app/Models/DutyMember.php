<?php

namespace App\Models;

use Database\Factories\DutyMemberFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

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
     * Menghitung status efektif kehadiran anggota secara dinamis:
     * 1. Jika sudah ada absen -> gunakan status tersebut.
     * 2. Jika waktu SEKARANG belum melewati Jam & Hari jadwal -> 'belum_waktunya'.
     * 3. Jika sudah melewati waktu (jam) tapi masih di hari yang sama -> 'belum_absen'.
     * 4. Jika sudah berganti hari (besoknya) tanpa absen -> 'alpa'.
     */
    public function getEffectiveStatusAttribute(): string
    {
        // 1. Ambil data absen terakhir milik siswa ini dari database
        $attendance = $this->latestAttendance ?? $this->attendances->first();

        if ($attendance) {
            return $attendance->status;
        }

        $schedule = $this->schedule;

        if (! $schedule || ! $schedule->date) {
            return 'belum_waktunya';
        }

        // Gabungkan tanggal dan waktu jadwal untuk perbandingan presisi
        $timeString = $schedule->time ? $schedule->time : '00:00:00';
        $scheduleDateTime = Carbon::parse($schedule->date->format('Y-m-d') . ' ' . $timeString);
        $now = now();

        // 2. Kalau sekarang masih SEBELUM jam piket (misal piket 15:30, sekarang 08:00 pagi)
        // Maka statusnya masih 'belum_waktunya' (tidak boleh alpa atau denda)
        if ($now->lt($scheduleDateTime)) {
            return 'belum_waktunya';
        }

        // 3. Kalau sekarang SUDAH MELEWATI jam piket, TAPI MASIH DI HARI YANG SAMA
        // (memberi kesempatan absen sampai tengah malam 23:59)
        if ($now->isSameDay($scheduleDateTime)) {
            return 'belum_absen';
        }

        // 4. Kalau sudah berganti hari (besoknya) dan siswa tidak absen sama sekali
        return 'alpa';
    }

    /**
     * Label teks yang rapi dan mudah dibaca untuk status efektif anggota.
     */
    public function getEffectiveStatusLabelAttribute(): string
    {
        return match ($this->effective_status) {
            'hadir' => 'Hadir (Terverifikasi)',
            'menunggu_verifikasi' => 'Menunggu Verifikasi PJ',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'belum_waktunya' => 'Belum Mulai (Jadwal Mendatang)',
            'belum_absen' => 'Belum Piket / Absen',
            'alpa' => 'Alpa (Denda Rp 5.000)',
            default => 'Belum Absen',
        };
    }
}

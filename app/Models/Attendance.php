<?php

namespace App\Models;

use Database\Factories\AttendanceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /** @use HasFactory<AttendanceFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'recorded_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    public function dutyMember()
    {
        return $this->belongsTo(DutyMember::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'hadir' => 'Hadir (Terverifikasi)',
            'menunggu_verifikasi' => 'Menunggu Verifikasi PJ',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            default => 'Alpa (Denda Rp 5.000)',
        };
    }
}

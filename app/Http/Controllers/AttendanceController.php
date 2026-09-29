<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\DutyMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Siswa mengunggah foto bukti piket untuk diverifikasi oleh PJ / Pembimbing.
     */
    public function submitProof(Request $request, DutyMember $dutyMember): RedirectResponse
    {
        $user = Auth::user();
        $isSelf = $dutyMember->user_id === $user->id;
        $isAdmin = $user->role === 'admin';
        $isPj = $dutyMember->schedule->dutyMembers()
            ->where('user_id', $user->id)
            ->where('is_pj', true)
            ->exists();

        if (! $isSelf && ! $isAdmin && ! $isPj) {
            abort(403, 'Anda tidak berhak mengunggah bukti untuk anggota lain.');
        }

        $validated = $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'proof_note' => 'nullable|string|max:500',
        ], [
            'proof_image.required' => 'Foto bukti hasil piket wajib dilampirkan.',
            'proof_image.image' => 'File bukti harus berupa gambar (JPG, PNG, atau WEBP).',
            'proof_image.max' => 'Ukuran foto maksimal adalah 5MB.',
        ]);

        $imagePath = $request->file('proof_image')->store('proofs', 'public');

        Attendance::updateOrCreate(
            ['duty_member_id' => $dutyMember->id],
            [
                'status' => 'menunggu_verifikasi',
                'proof_image' => $imagePath,
                'proof_note' => $validated['proof_note'] ?? 'Tugas piket selesai dilaksanakan.',
                'recorded_at' => now(),
            ]
        );

        return back()->with('success', 'Bukti piket berhasil dikirim! Menunggu verifikasi dari PJ Piket atau Pembimbing.');
    }

    /**
     * PJ Piket atau Pembimbing Rayon memverifikasi bukti piket (Setujui / Tolak).
     */
    public function verify(Request $request, DutyMember $dutyMember): RedirectResponse
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';
        $isPj = $dutyMember->schedule->dutyMembers()
            ->where('user_id', $user->id)
            ->where('is_pj', true)
            ->exists();

        if (! $isAdmin && ! $isPj) {
            abort(403, 'Hanya Penanggung Jawab (PJ) piket atau Pembimbing yang berhak memverifikasi.');
        }

        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        $lastAttendance = $dutyMember->latestAttendance;

        if ($validated['action'] === 'approve') {
            Attendance::updateOrCreate(
                ['duty_member_id' => $dutyMember->id],
                [
                    'status' => 'hadir',
                    'proof_image' => $lastAttendance?->proof_image,
                    'proof_note' => $lastAttendance?->proof_note,
                    'verified_by' => $user->id,
                    'verified_at' => now(),
                    'recorded_at' => now(),
                ]
            );

            return back()->with('success', "Bukti piket {$dutyMember->user->name} disetujui! Status berhasil dicatat sebagai HADIR.");
        }

        Attendance::updateOrCreate(
            ['duty_member_id' => $dutyMember->id],
            [
                'status' => 'alpa',
                'proof_image' => $lastAttendance?->proof_image,
                'proof_note' => 'Ditolak: hasil piket belum bersih atau tidak sesuai standar.',
                'verified_by' => $user->id,
                'verified_at' => now(),
                'recorded_at' => now(),
            ]
        );

        return back()->with('error', "Piket {$dutyMember->user->name} ditolak / belum bersih! Status diubah menjadi ALPA (Denda Rp 5.000).");
    }

    /**
     * Manual update status kehadiran oleh Admin / Pembimbing.
     */
    public function update(Request $request, DutyMember $dutyMember): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpa,menunggu_verifikasi',
        ]);

        $lastAttendance = $dutyMember->latestAttendance;

        Attendance::updateOrCreate(
            ['duty_member_id' => $dutyMember->id],
            [
                'status' => $validated['status'],
                'proof_image' => $lastAttendance?->proof_image,
                'proof_note' => $lastAttendance?->proof_note,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'recorded_at' => now(),
            ]
        );

        return back()->with('success', 'Status absensi berhasil diperbarui!');
    }
}

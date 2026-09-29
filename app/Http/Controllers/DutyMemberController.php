<?php

namespace App\Http\Controllers;

use App\Models\DutyMember;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DutyMemberController extends Controller
{
    public function store(Request $request, Schedule $schedule): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ], [
            'user_id.required' => 'Pilih siswa yang akan ditugaskan.',
            'user_id.exists' => 'Siswa yang dipilih tidak valid.',
        ]);

        $exists = DutyMember::where('schedule_id', $schedule->id)
            ->where('user_id', $validated['user_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['user_id' => 'Siswa ini sudah terdaftar pada jadwal ini.']);
        }

        DutyMember::create([
            'schedule_id' => $schedule->id,
            'user_id' => $validated['user_id'],
        ]);

        return back()->with('success', 'Anggota piket berhasil ditambahkan ke jadwal!');
    }

    public function destroy(DutyMember $dutyMember): RedirectResponse
    {
        $dutyMember->delete();

        return back()->with('success', 'Anggota piket berhasil dihapus dari jadwal.');
    }

    public function togglePj(DutyMember $dutyMember): RedirectResponse
    {
        $dutyMember->update([
            'is_pj' => ! $dutyMember->is_pj,
        ]);

        $statusText = $dutyMember->is_pj ? 'dijadikan Penanggung Jawab (PJ) piket' : 'dicopot dari status Penanggung Jawab (PJ) piket';

        return back()->with('success', "Status {$dutyMember->user->name} {$statusText}.");
    }
}

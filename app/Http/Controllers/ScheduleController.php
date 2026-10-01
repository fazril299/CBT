<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    /**
     * Tampilkan daftar seluruh jadwal piket dengan opsi filter tab.
     */
    public function index(Request $request): View
    {
        $filter = $request->query('filter', 'all');

        // Hanya eager-load dutyMembers.user untuk performa kartu yang ringan
        $query = Schedule::with('dutyMembers.user')->orderBy('date', 'asc');

        if ($filter === 'my' && Auth::check()) {
            $userId = Auth::id();
            $query->whereHas('dutyMembers', fn ($q) => $q->where('user_id', $userId));
        } elseif ($filter === 'piket_wc') {
            $query->piketWc();
        } elseif ($filter === 'piket_rayon') {
            $query->piketRayon();
        }

        $schedules = $query->get();

        // Hitung total untuk label tab filter
        $totalAll = Schedule::count();
        $totalWc = Schedule::piketWc()->count();
        $totalRayon = Schedule::piketRayon()->count();
        $totalMy = Auth::check()
            ? Schedule::whereHas('dutyMembers', fn ($q) => $q->where('user_id', Auth::id()))->count()
            : 0;

        return view('schedules.index', compact(
            'schedules',
            'filter',
            'totalAll',
            'totalWc',
            'totalRayon',
            'totalMy'
        ));
    }

    /**
     * Tampilkan detail jadwal piket, anggota, dan form absensi/verifikasi.
     */
    public function show(Schedule $schedule): View
    {
        $schedule->load([
            'dutyMembers.user',
            'dutyMembers.latestAttendance.verifiedBy',
            'dutyMembers.attendances.verifiedBy',
            'activities',
        ]);

        $availableStudents = User::where('role', 'siswa')
            ->whereNotIn('id', $schedule->dutyMembers->pluck('user_id'))
            ->get();

        $currentUser = Auth::user();
        $isPj = $currentUser ? $schedule->isPj($currentUser->id) : false;
        $myDutyMember = $currentUser ? $schedule->dutyMembers->firstWhere('user_id', $currentUser->id) : null;

        return view('schedules.show', compact('schedule', 'availableStudents', 'isPj', 'myDutyMember'));
    }

    /**
     * Perbarui status pelaksanaan jadwal (belum_dilakukan, sedang_berlangsung, selesai).
     */
    public function updateStatus(Request $request, Schedule $schedule): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:belum_dilakukan,sedang_berlangsung,selesai',
        ]);

        $schedule->update(['status' => $validated['status']]);

        return back()->with('success', 'Status jadwal berhasil diperbarui!');
    }
}

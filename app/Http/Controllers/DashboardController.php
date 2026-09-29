<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama Dashboard dengan statistik dan jadwal terkini.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';

        // Hitung statistik ringkas untuk kartu atas
        $totalPiketWc = Schedule::piketWc()->count();
        $totalPiketRayon = Schedule::piketRayon()->count();
        $totalStudents = User::where('role', 'siswa')->count();
        $completedSchedules = Schedule::where('status', 'selesai')->count();
        $pendingActivities = Activity::where('status', false)->count();

        // Cari jadwal giliran terdekat khusus siswa yang sedang login
        $myNextSchedule = Schedule::with('dutyMembers.user')
            ->whereHas('dutyMembers', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->first();

        // 6 jadwal aktif terdekat untuk monitoring
        $recentSchedules = Schedule::with('dutyMembers.user')
            ->orderBy('date', 'asc')
            ->take(6)
            ->get();

        // 5 checklist tugas pengerjaan piket
        $activityList = Activity::orderBy('status', 'asc')
            ->orderBy('target_date', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'user',
            'isAdmin',
            'totalPiketWc',
            'totalPiketRayon',
            'totalStudents',
            'completedSchedules',
            'pendingActivities',
            'myNextSchedule',
            'recentSchedules',
            'activityList'
        ));
    }
}

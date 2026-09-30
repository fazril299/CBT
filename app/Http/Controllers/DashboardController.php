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

        // MENCARI JADWAL PIKET UNTUK SISWA YANG SEDANG LOGIN (Bagian Penting)
        // 1. Buka tabel Jadwal (Schedule)
        // 2. Cari jadwal di mana anggotanya (dutyMembers) ada ID siswa yang sedang login saat ini
        // 3. Pastikan tanggal jadwalnya hari ini atau ke depannya (>= hari ini)
        // 4. Urutkan dari yang terdekat (asc) lalu ambil jadwal pertama saja (first)
        $myNextSchedule = Schedule::with('dutyMembers.user')
            ->whereHas('dutyMembers', function ($query) use ($user) {
                $query->where('user_id', $user->id); // Filter ID siswa yang login
            })
            ->where('date', '>=', now()->toDateString()) // Filter tanggal
            ->orderBy('date', 'asc')
            ->first(); // Ambil 1 jadwal terdekat

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


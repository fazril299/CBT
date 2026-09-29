<?php

namespace App\Http\Controllers;

use App\Models\DutyMember;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->query('filter', 'all');

        $query = Schedule::with(['dutyMembers.user', 'dutyMembers.attendances'])
            ->orderBy('date', 'asc');

        if ($filter === 'my' && Auth::check()) {
            $userId = Auth::id();
            $query->whereHas('dutyMembers', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        } elseif ($filter === 'piket_wc') {
            $query->where('piket_type', 'piket_wc');
        } elseif ($filter === 'piket_rayon') {
            $query->where('piket_type', 'piket_rayon');
        }

        $schedules = $query->get();

        // Count totals for quick tabs
        $totalAll = Schedule::count();
        $totalWc = Schedule::where('piket_type', 'piket_wc')->count();
        $totalRayon = Schedule::where('piket_type', 'piket_rayon')->count();
        $totalMy = Auth::check() ? Schedule::whereHas('dutyMembers', function ($q) {
            $q->where('user_id', Auth::id());
        })->count() : 0;

        return view('schedules.index', compact('schedules', 'filter', 'totalAll', 'totalWc', 'totalRayon', 'totalMy'));
    }

    public function show(Schedule $schedule): View
    {
        $schedule->load(['dutyMembers.user', 'dutyMembers.latestAttendance.verifiedBy', 'dutyMembers.attendances.verifiedBy', 'activities']);
        $availableStudents = User::where('role', 'siswa')
            ->whereNotIn('id', $schedule->dutyMembers->pluck('user_id'))
            ->get();

        $currentUser = Auth::user();
        $isPj = $currentUser ? $schedule->dutyMembers->where('user_id', $currentUser->id)->where('is_pj', true)->isNotEmpty() : false;
        $myDutyMember = $currentUser ? $schedule->dutyMembers->firstWhere('user_id', $currentUser->id) : null;

        return view('schedules.show', compact('schedule', 'availableStudents', 'isPj', 'myDutyMember'));
    }

    public function create(): View
    {
        $students = User::where('role', 'siswa')->orderBy('name')->get();

        return view('schedules.create', compact('students'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'piket_type' => 'required|in:piket_wc,piket_rayon',
            'location' => 'required|string|max:100',
            'date' => 'required|date',
            'day' => 'required|string',
            'time' => 'required',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ], [
            'piket_type.required' => 'Pilih jenis piket (Piket WC atau Piket Rayon).',
            'piket_type.in' => 'Jenis piket hanya boleh Piket WC atau Piket Rayon.',
            'location.required' => 'Nama lokasi / area piket wajib diisi.',
            'date.required' => 'Tanggal piket wajib diisi.',
            'day.required' => 'Hari piket wajib dipilih.',
            'time.required' => 'Waktu piket wajib diisi.',
            'user_ids.required' => 'Anggota piket wajib dipilih minimal 1 orang.',
            'user_ids.min' => 'Pilih minimal 1 orang anggota piket.',
        ]);

        $schedule = Schedule::create([
            'piket_type' => $validated['piket_type'],
            'location' => $validated['location'],
            'date' => $validated['date'],
            'day' => $validated['day'],
            'time' => $validated['time'],
            'status' => 'belum_dilakukan',
        ]);

        $pjUserId = $request->input('pj_user_id');

        foreach ($validated['user_ids'] as $userId) {
            DutyMember::create([
                'schedule_id' => $schedule->id,
                'user_id' => $userId,
                'is_pj' => ($pjUserId && (int) $userId === (int) $pjUserId),
            ]);
        }

        return redirect()->route('schedules.show', $schedule->id)->with('success', 'Jadwal '.$schedule->type_label.' dan anggota berhasil dibuat!');
    }

    public function edit(Schedule $schedule): View
    {
        $students = User::where('role', 'siswa')->orderBy('name')->get();

        return view('schedules.edit', compact('schedule', 'students'));
    }

    public function update(Request $request, Schedule $schedule): RedirectResponse
    {
        $validated = $request->validate([
            'piket_type' => 'required|in:piket_wc,piket_rayon',
            'location' => 'required|string|max:100',
            'date' => 'required|date',
            'day' => 'required|string',
            'time' => 'required',
            'status' => 'required|in:belum_dilakukan,sedang_berlangsung,selesai',
        ], [
            'piket_type.required' => 'Pilih jenis piket (Piket WC atau Piket Rayon).',
            'location.required' => 'Nama lokasi / area piket wajib diisi.',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.show', $schedule->id)->with('success', 'Data jadwal '.$schedule->type_label.' berhasil diperbarui!');
    }

    public function updateStatus(Request $request, Schedule $schedule): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:belum_dilakukan,sedang_berlangsung,selesai',
        ]);

        $schedule->update(['status' => $validated['status']]);

        return back()->with('success', 'Status jadwal berhasil diperbarui!');
    }

    public function destroy(Schedule $schedule): RedirectResponse
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Jadwal piket berhasil dihapus!');
    }
}

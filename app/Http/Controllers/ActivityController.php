<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(): View
    {
        $activities = Activity::with(['user', 'schedule'])
            ->orderBy('target_date', 'asc')
            ->get();

        return view('activities.index', compact('activities'));
    }

    public function create(): View
    {
        $schedules = Schedule::orderBy('date', 'desc')->get();

        return view('activities.create', compact('schedules'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|min:4',
            'description' => 'required|min:15',
            'target_date' => 'required|date',
            'schedule_id' => 'nullable|exists:schedules,id',
        ], [
            'title.required' => 'Nama kegiatan wajib diisi.',
            'title.min' => 'Nama kegiatan minimal 4 karakter.',
            'description.required' => 'Deskripsi kegiatan wajib diisi.',
            'description.min' => 'Deskripsi minimal 15 karakter.',
            'target_date.required' => 'Target selesai kegiatan wajib diisi.',
            'target_date.date' => 'Target selesai harus berformat tanggal dan waktu yang valid.',
        ]);

        Activity::create([
            'user_id' => Auth::id(),
            'schedule_id' => $validated['schedule_id'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'target_date' => $validated['target_date'],
            'done_time' => null,
            'status' => false,
        ]);

        return redirect()->route('activities.index')->with('success', 'Kegiatan piket berhasil ditambahkan!');
    }

    public function toggleComplete(Activity $activity): RedirectResponse
    {
        $newStatus = ! $activity->status;

        $activity->update([
            'status' => $newStatus,
            'done_time' => $newStatus ? now() : null,
        ]);

        $message = $newStatus ? 'Kegiatan ditandai telah selesai.' : 'Status kegiatan diubah menjadi belum selesai.';

        return back()->with('success', $message);
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return back()->with('success', 'Kegiatan berhasil dihapus.');
    }
}

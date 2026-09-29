<?php

use App\Models\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('piket:check', function () {
    $schedules = Schedule::with('dutyMembers.attendances')->get();
    foreach ($schedules as $s) {
        $this->info("ID: {$s->id} | {$s->day} ({$s->date->toDateString()}) | Schedule Status: {$s->status} | Members: ".$s->dutyMembers->count());
        foreach ($s->dutyMembers as $dm) {
            $att = $dm->latestAttendance;
            $this->line("   - {$dm->user->name} | Att: ".($att ? $att->status : 'NULL'));
        }
    }
});

Artisan::command('piket:sync-dates', function () {

    $today = now()->toDateString();

    // Future schedules must be 'belum_dilakukan'
    $updatedFuture = Schedule::where('date', '>', $today)
        ->update(['status' => 'belum_dilakukan']);

    // Today's schedules: if not selesai, make sure it is sedang_berlangsung
    $updatedToday = Schedule::where('date', $today)
        ->where('status', '!=', 'selesai')
        ->update(['status' => 'sedang_berlangsung']);

    $this->info("Synced schedules: {$updatedFuture} future schedule(s) set to 'belum_dilakukan', {$updatedToday} today's schedule(s) set to 'sedang_berlangsung'.");
});

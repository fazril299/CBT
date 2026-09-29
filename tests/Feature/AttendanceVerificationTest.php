<?php

namespace Tests\Feature;

use App\Models\DutyMember;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AttendanceVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_submit_photo_proof(): void
    {
        Storage::fake('public');

        $student = User::factory()->create(['role' => 'siswa']);
        $schedule = Schedule::create([
            'piket_type' => 'piket_rayon',
            'location' => 'Ruang Kelas Rayon Cisarua 5',
            'date' => now()->toDateString(),
            'day' => 'Senin',
            'time' => '15:30:00',
            'status' => 'belum_dilakukan',
        ]);

        $dutyMember = DutyMember::create([
            'schedule_id' => $schedule->id,
            'user_id' => $student->id,
            'is_pj' => false,
        ]);

        $file = UploadedFile::fake()->image('bukti_piket.jpg');

        $response = $this->actingAs($student)->post(route('attendances.submit-proof', $dutyMember->id), [
            'proof_image' => $file,
            'proof_note' => 'Ruang kelas sudah disapu dan dipel bersih.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('attendances', [
            'duty_member_id' => $dutyMember->id,
            'status' => 'menunggu_verifikasi',
            'proof_note' => 'Ruang kelas sudah disapu dan dipel bersih.',
        ]);
    }

    public function test_pj_can_verify_and_approve_duty(): void
    {
        Storage::fake('public');

        $pj = User::factory()->create(['role' => 'siswa', 'name' => 'PJ Bilqis']);
        $student = User::factory()->create(['role' => 'siswa', 'name' => 'Siswa Alif']);

        $schedule = Schedule::create([
            'piket_type' => 'piket_rayon',
            'location' => 'Ruang Kelas Rayon Cisarua 5',
            'date' => now()->toDateString(),
            'day' => 'Senin',
            'time' => '15:30:00',
            'status' => 'belum_dilakukan',
        ]);

        DutyMember::create([
            'schedule_id' => $schedule->id,
            'user_id' => $pj->id,
            'is_pj' => true,
        ]);

        $dutyMember = DutyMember::create([
            'schedule_id' => $schedule->id,
            'user_id' => $student->id,
            'is_pj' => false,
        ]);

        $response = $this->actingAs($pj)->post(route('attendances.verify', $dutyMember->id), [
            'action' => 'approve',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('attendances', [
            'duty_member_id' => $dutyMember->id,
            'status' => 'hadir',
            'verified_by' => $pj->id,
        ]);
    }

    public function test_pj_can_reject_duty(): void
    {
        Storage::fake('public');

        $pj = User::factory()->create(['role' => 'siswa', 'name' => 'PJ Bilqis']);
        $student = User::factory()->create(['role' => 'siswa', 'name' => 'Siswa Alif']);

        $schedule = Schedule::create([
            'piket_type' => 'piket_rayon',
            'location' => 'Ruang Kelas Rayon Cisarua 5',
            'date' => now()->toDateString(),
            'day' => 'Senin',
            'time' => '15:30:00',
            'status' => 'belum_dilakukan',
        ]);

        DutyMember::create([
            'schedule_id' => $schedule->id,
            'user_id' => $pj->id,
            'is_pj' => true,
        ]);

        $dutyMember = DutyMember::create([
            'schedule_id' => $schedule->id,
            'user_id' => $student->id,
            'is_pj' => false,
        ]);

        $response = $this->actingAs($pj)->post(route('attendances.verify', $dutyMember->id), [
            'action' => 'reject',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('attendances', [
            'duty_member_id' => $dutyMember->id,
            'status' => 'alpa',
            'verified_by' => $pj->id,
        ]);
    }

    public function test_non_pj_student_cannot_verify_others(): void
    {
        $student1 = User::factory()->create(['role' => 'siswa']);
        $student2 = User::factory()->create(['role' => 'siswa']);

        $schedule = Schedule::create([
            'piket_type' => 'piket_rayon',
            'location' => 'Ruang Kelas Rayon Cisarua 5',
            'date' => now()->toDateString(),
            'day' => 'Senin',
            'time' => '15:30:00',
            'status' => 'belum_dilakukan',
        ]);

        $dutyMember = DutyMember::create([
            'schedule_id' => $schedule->id,
            'user_id' => $student2->id,
            'is_pj' => false,
        ]);

        $response = $this->actingAs($student1)->post(route('attendances.verify', $dutyMember->id), [
            'action' => 'approve',
        ]);

        $response->assertStatus(403);
    }

    public function test_future_schedule_member_has_status_belum_waktunya(): void
    {
        $student = User::factory()->create(['role' => 'siswa']);
        $schedule = Schedule::create([
            'piket_type' => 'piket_rayon',
            'location' => 'Ruang Kelas Rayon Cisarua 5',
            'date' => now()->addDay()->toDateString(),
            'day' => 'Selasa',
            'time' => '15:30:00',
            'status' => 'belum_dilakukan',
        ]);

        $dutyMember = DutyMember::create([
            'schedule_id' => $schedule->id,
            'user_id' => $student->id,
            'is_pj' => false,
        ]);

        $this->assertEquals('belum_waktunya', $dutyMember->effective_status);
        $this->assertEquals(0, $dutyMember->denda_amount);

        $response = $this->actingAs($student)->get(route('schedules.show', $schedule->id));
        $response->assertOk();
        $response->assertSee('Belum Waktunya');
        $response->assertDontSee('Alpa (Denda Rp 5.000)');
    }

    public function test_today_ongoing_schedule_member_is_belum_absen(): void
    {
        $student = User::factory()->create(['role' => 'siswa']);
        $schedule = Schedule::create([
            'piket_type' => 'piket_rayon',
            'location' => 'Ruang Kelas Rayon Cisarua 5',
            'date' => now()->toDateString(),
            'day' => 'Senin',
            'time' => '15:30:00',
            'status' => 'sedang_berlangsung',
        ]);

        $dutyMember = DutyMember::create([
            'schedule_id' => $schedule->id,
            'user_id' => $student->id,
            'is_pj' => false,
        ]);

        $this->assertEquals('belum_absen', $dutyMember->effective_status);
        $this->assertEquals(0, $dutyMember->denda_amount);

        $response = $this->actingAs($student)->get(route('schedules.show', $schedule->id));
        $response->assertOk();
        $response->assertSee('Belum Piket / Absen');
        $response->assertDontSee('Alpa (Denda Rp 5.000)');
    }
}

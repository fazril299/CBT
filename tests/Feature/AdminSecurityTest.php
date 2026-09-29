<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_panel(): void
    {
        $response = $this->get('/admin');

        // Guests should be redirected to the admin login page
        $response->assertRedirect('/admin/login');
    }

    public function test_regular_student_cannot_access_admin_panel(): void
    {
        $student = User::factory()->create([
            'role' => 'siswa',
        ]);

        $response = $this->actingAs($student)->get('/admin');

        // Students should get a 403 Forbidden because they are not admins
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_panel(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/users');

        // Admins should be able to access the Users resource
        $response->assertStatus(200);
    }
}

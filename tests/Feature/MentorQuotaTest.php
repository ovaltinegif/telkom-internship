<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Division;
use App\Models\MentorProfile;
use App\Models\Internship;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class MentorQuotaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_assign_intern_to_full_quota_mentor()
    {
        // 1. Create Admin
        $admin = User::factory()->create(['role' => 'admin']);

        // 2. Create Division
        $division = Division::create(['name' => 'IT Division']);

        // 3. Create Mentor with Quota 1
        $mentor = User::factory()->create(['role' => 'mentor']);
        MentorProfile::create([
            'user_id' => $mentor->id,
            'nik' => '12345',
            'position' => 'Manager',
            'quota' => 1
        ]);

        // 4. Create Student 1 & 2
        $student1 = User::factory()->create(['role' => 'student']);
        $student2 = User::factory()->create(['role' => 'student']);

        // 5. Assign Student 1 to Mentor (Quota 1/1)
        $this->actingAs($admin)->post(route('admin.internship.store'), [
            'student_id' => $student1->id,
            'mentor_id' => $mentor->id,
            'division_id' => $division->id,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
        ])->assertRedirect(route('admin.dashboard'));

        // 6. Assign Student 2 to Mentor (Quota Exceeded)
        $response = $this->actingAs($admin)->post(route('admin.internship.store'), [
            'student_id' => $student2->id,
            'mentor_id' => $mentor->id,
            'division_id' => $division->id,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
        ]);

        // 7. Assert Error
        $response->assertSessionHas('error');
    }
}

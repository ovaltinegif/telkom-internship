<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Internship;
use App\Models\InternshipExtension;
use App\Models\Document;
use App\Models\Division;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InternshipExtensionTest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_admin_can_view_extension_requests()
    {
        $admin = User::firstOrCreate(
        ['email' => 'admin_test@example.com'],
        ['name' => 'Admin Test', 'password' => bcrypt('password'), 'role' => 'admin']
        );
        $student = User::create([
            'name' => 'Student Test',
            'email' => 'student_test@example.com',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);

        // Create student profile to avoid view errors if it relies on it
        $student->studentProfile()->create(['nim' => '12345', 'university' => 'Test Uni', 'major' => 'IT']);

        $division = Division::firstOrCreate(['name' => 'IT Division']);

        $internship = Internship::create([
            'student_id' => $student->id,
            'division_id' => $division->id,
            'mentor_id' => $admin->id, // Assign admin as mentor for simplicity
            'status' => 'active',
            'start_date' => now()->subMonths(2),
            'end_date' => now()->addMonth()
        ]);

        $extension = InternshipExtension::create([
            'internship_id' => $internship->id,
            'new_start_date' => now()->addMonth(),
            'new_end_date' => now()->addMonths(2),
            'reason' => 'Need more time',
            'file_path' => 'extensions/test.pdf',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($admin)->get(route('admin.internships.index', ['status' => 'extension']));

        $response->assertStatus(200);
        $response->assertSee($student->name);
    }

    public function test_admin_can_approve_extension_request()
    {
        $admin = User::firstOrCreate(
        ['email' => 'admin_test@example.com'],
        ['name' => 'Admin Test', 'password' => bcrypt('password'), 'role' => 'admin']
        );
        $student = User::create([
            'name' => 'Student Approve',
            'email' => 'student_approve@example.com',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);

        $student->studentProfile()->create(['nim' => '12345', 'university' => 'Test Uni', 'major' => 'IT']);

        $division = Division::firstOrCreate(['name' => 'IT Division']);

        $currentEndDate = now()->addMonth()->format('Y-m-d');
        $newEndDate = now()->addMonths(2)->format('Y-m-d');

        $internship = Internship::create([
            'student_id' => $student->id,
            'division_id' => $division->id,
            'mentor_id' => $admin->id,
            'status' => 'active',
            'start_date' => now()->subMonths(2),
            'end_date' => $currentEndDate
        ]);

        $extension = InternshipExtension::create([
            'internship_id' => $internship->id,
            // Assuming new start date is previous end date
            'new_start_date' => $currentEndDate,
            'new_end_date' => $newEndDate,
            'reason' => 'Need more time',
            'file_path' => 'extensions/test.pdf',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.internships.approveExtension', $extension->id));

        $response->assertRedirect();

        $this->assertDatabaseHas('internship_extensions', [
            'id' => $extension->id,
            'status' => 'approved'
        ]);

        $this->assertDatabaseHas('internships', [
            'id' => $internship->id,
            'end_date' => $newEndDate
        ]);
    }

    public function test_admin_can_reject_extension_request()
    {
        $admin = User::firstOrCreate(
        ['email' => 'admin_test@example.com'],
        ['name' => 'Admin Test', 'password' => bcrypt('password'), 'role' => 'admin']
        );
        $student = User::create([
            'name' => 'Student Reject',
            'email' => 'student_reject@example.com',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);

        $student->studentProfile()->create(['nim' => '12345', 'university' => 'Test Uni', 'major' => 'IT']);

        $division = Division::firstOrCreate(['name' => 'IT Division']);

        $currentEndDate = now()->addMonth()->format('Y-m-d');
        $newEndDate = now()->addMonths(2)->format('Y-m-d');

        $internship = Internship::create([
            'student_id' => $student->id,
            'division_id' => $division->id,
            'mentor_id' => $admin->id,
            'status' => 'active',
            'start_date' => now()->subMonths(2),
            'end_date' => $currentEndDate
        ]);

        $extension = InternshipExtension::create([
            'internship_id' => $internship->id,
            'new_start_date' => $currentEndDate,
            'new_end_date' => $newEndDate,
            'reason' => 'Need more time',
            'file_path' => 'extensions/test.pdf',
            'status' => 'pending'
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.internships.rejectExtension', $extension->id));

        $response->assertRedirect();

        $this->assertDatabaseHas('internship_extensions', [
            'id' => $extension->id,
            'status' => 'rejected'
        ]);

        // End date should NOT change
        $this->assertDatabaseHas('internships', [
            'id' => $internship->id,
            'end_date' => $currentEndDate
        ]);
    }

    public function test_student_can_submit_extension_request()
    {
        Storage::fake('public');

        $student = User::create([
            'name' => 'Student Submit',
            'email' => 'student_submit@example.com',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);

        $division = Division::firstOrCreate(['name' => 'IT Division']);
        $currentEndDate = now()->addMonth()->startOfDay();

        $internship = Internship::create([
            'student_id' => $student->id,
            'division_id' => $division->id,
            'status' => 'active',
            'start_date' => now()->subMonths(2),
            'end_date' => $currentEndDate->toDateString()
        ]);

        $newEndDate = now()->addMonths(2)->toDateString();
        $file = \Illuminate\Http\UploadedFile::fake()->create('extension.pdf', 100);

        $response = $this->actingAs($student)->post(route('documents.storeExtension'), [
            'end_date' => $newEndDate,
            'file' => $file
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('internship_extensions', [
            'internship_id' => $internship->id,
            'new_start_date' => $currentEndDate->copy()->addDay()->toDateString(),
            'new_end_date' => $newEndDate,
            'status' => 'pending'
        ]);
    }

    public function test_student_cannot_submit_extension_with_earlier_end_date()
    {
        $student = User::create([
            'name' => 'Student Invalid',
            'email' => 'student_invalid@example.com',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);

        $currentEndDate = now()->addMonth();

        $internship = Internship::create([
            'student_id' => $student->id,
            'status' => 'active',
            'start_date' => now()->subMonths(2),
            'end_date' => $currentEndDate->toDateString()
        ]);

        $invalidEndDate = $currentEndDate->copy()->subDay()->toDateString();
        $file = \Illuminate\Http\UploadedFile::fake()->create('extension.pdf', 100);

        $response = $this->actingAs($student)->post(route('documents.storeExtension'), [
            'end_date' => $invalidEndDate,
            'file' => $file
        ]);

        $response->assertSessionHasErrors('end_date');
    }

    public function test_student_can_re_submit_extension_after_rejection()
    {
        Storage::fake('public');

        $student = User::create([
            'name' => 'Student Retry',
            'email' => 'student_retry@example.com',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);

        $internship = Internship::create([
            'student_id' => $student->id,
            'status' => 'active',
            'start_date' => now()->subMonths(2),
            'end_date' => now()->addMonth()->toDateString()
        ]);

        // Create a rejected extension
        InternshipExtension::create([
            'internship_id' => $internship->id,
            'new_start_date' => now()->addMonth()->toDateString(),
            'new_end_date' => now()->addMonths(2)->toDateString(),
            'status' => 'rejected',
            'file_path' => 'old_extension.pdf'
        ]);

        $newEndDate = now()->addMonths(3)->toDateString();
        $file = \Illuminate\Http\UploadedFile::fake()->create('new_extension.pdf', 100);

        $response = $this->actingAs($student)->post(route('documents.storeExtension'), [
            'end_date' => $newEndDate,
            'file' => $file
        ]);

        $response->assertRedirect();

        // Assert that a new record exists with pending status
        $this->assertDatabaseHas('internship_extensions', [
            'internship_id' => $internship->id,
            'new_end_date' => $newEndDate,
            'status' => 'pending'
        ]);
    }
}

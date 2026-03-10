<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Internship;
use App\Models\MentorProfile;

echo "--- VERIFICATION REPORT ---\n";

$mentors = User::where('role', 'mentor')->get();
echo "Mentors: " . $mentors->count() . " (Expected: 4)\n";

$internships = Internship::count();
echo "Total Internships: " . $internships . " (Expected: 40)\n";

echo "Pending: " . Internship::where('status', 'pending')->count() . " (Expected: 10)\n";
echo "Onboarding: " . Internship::where('status', 'onboarding')->count() . " (Expected: 5)\n";
echo "Active: " . Internship::where('status', 'active')->count() . " (Expected: 20)\n";
echo "Finished: " . Internship::where('status', 'finished')->count() . " (Expected: 5)\n";

foreach ($mentors as $m) {
    $activeCount = $m->mentoredInternships()->where('status', 'active')->count();
    $quota = $m->mentorProfile->quota;
    echo "Mentor ID {$m->id}: Quota {$quota}, Active Interns {$activeCount}\n";
}
echo "---------------------------\n";

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendWeeklyLogbookDigest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-weekly-logbook-digest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a weekly email digest to mentors about pending logbooks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to send weekly logbook digests...');

        // Find all mentors who have interns with pending logbooks
        $mentors = \App\Models\User::where('role', 'mentor')->get();
        $emailsSent = 0;

        foreach ($mentors as $mentor) {
            $studentsData = [];

            // Get all active internships for this mentor
            $internships = \App\Models\Internship::where('mentor_id', $mentor->id)
                ->where('status', 'active')
                ->with(['student', 'dailyLogbooks' => function ($query) {
                $query->where('status', 'pending');
            }])
                ->get();

            foreach ($internships as $internship) {
                $pendingCount = $internship->dailyLogbooks->count();
                if ($pendingCount > 0) {
                    $studentsData[] = [
                        'student_name' => $internship->student->name,
                        'pending_count' => $pendingCount,
                    ];
                }
            }

            // If there are students with pending logbooks for this mentor, send email
            if (count($studentsData) > 0) {
                try {
                    \Illuminate\Support\Facades\Mail::to($mentor->email)->queue(new \App\Mail\WeeklyLogbookDigest($mentor, $studentsData));
                    $emailsSent++;
                    $this->info("Sent digest to {$mentor->email}");
                }
                catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Failed to send weekly digest to {$mentor->email}: " . $e->getMessage());
                    $this->error("Failed to send to {$mentor->email}");
                }
            }
        }

        $this->info("Finished sending weekly logbook digests. Total emails queued: {$emailsSent}");
    }
}

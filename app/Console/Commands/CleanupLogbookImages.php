<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupLogbookImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logbook:cleanup-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up orphaned Trix images from logbooks older than 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai pembersihan gambar logbook usang...');

        $disk = \Illuminate\Support\Facades\Storage::disk('public');
        $directory = 'logbook-images';

        if (!$disk->exists($directory)) {
            $this->info("Direktori {$directory} tidak ditemukan. Selesai.");
            return;
        }

        $files = $disk->files($directory);
        $now = \Carbon\Carbon::now();
        $deletedCount = 0;

        foreach ($files as $file) {
            $lastModified = \Carbon\Carbon::createFromTimestamp($disk->lastModified($file));

            // Jika file dibuat/dimodifikasi lebih dari 24 jam yang lalu
            if ($now->diffInHours($lastModified) >= 24) {
                $filename = basename($file);

                // Cek apakah file ini dipakai di tabel daily_logbooks
                // Asumsi: URL gambar tersimpan di konten activity, berupa string URL
                $isUsed = \App\Models\DailyLogbook::where('activity', 'LIKE', '%' . $filename . '%')->exists();

                if (!$isUsed) {
                    $disk->delete($file);
                    $this->line("- Mengahapus {$filename}");
                    $deletedCount++;
                }
            }
        }

        $this->info("Pembersihan selesai. Total file dihapus: {$deletedCount}.");
    }
}

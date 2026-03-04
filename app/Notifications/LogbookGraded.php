<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LogbookGraded extends Notification
{
    use Queueable;

    public $logbook;

    /**
     * Create a new notification instance.
     */
    public function __construct($logbook)
    {
        $this->logbook = $logbook;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Defaulting to In-App Bell notifications only
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $statusText = $this->logbook->status === 'approved' ? 'disetujui' : 'direvisi';
        $icon = $this->logbook->status === 'approved' ? 'check-circle' : 'exclamation-circle';

        return [
            'title' => "Logbook " . ucfirst($statusText),
            'message' => "Logbook tanggal " . \Carbon\Carbon::parse($this->logbook->date)->format('d M') . " telah diperiksa oleh mentor Anda.",
            'icon' => $icon,
            'url' => '/dashboard',
            'logbook_id' => $this->logbook->id
        ];
    }
}

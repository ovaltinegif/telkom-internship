<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InternPermissionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public array $permissionData;
    public User $internUser;

    /**
     * Create a new message instance.
     */
    public function __construct(array $permissionData, User $internUser)
    {
        $this->permissionData = $permissionData;
        $this->internUser = $internUser;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[Aksi Diperlukan] Pengajuan Izin Magang - ' . $this->internUser->name,
            replyTo: [
                new Address($this->internUser->email, $this->internUser->name),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.intern_permission',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

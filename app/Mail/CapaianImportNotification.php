<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CapaianImportNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $successCount;
    public $importYear;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, int $successCount, int $importYear)
    {
        $this->user = $user;
        $this->successCount = $successCount;
        $this->importYear = $importYear;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[NOTIFIKASI] Unggah Massal Excel Capaian - Kab/Kota ' . ($this->user->wilayah ?? '-'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.capaian_import_notification',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}

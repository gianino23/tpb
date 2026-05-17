<?php

namespace App\Mail;

use App\Models\CapaianKabupaten;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CapaianNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $capaian;

    /**
     * Create a new message instance.
     */
    public function __construct(CapaianKabupaten $capaian)
    {
        $this->capaian = $capaian;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusText = '';
        if ($this->capaian->status == 'Menunggu Verifikasi') {
            $statusText = 'Dokumen Diterima';
        } elseif ($this->capaian->status == 'Terverifikasi') {
            $statusText = 'Verifikasi Diterima';
        } elseif ($this->capaian->status == 'Ditolak') {
            $statusText = 'Verifikasi Ditolak';
        }

        return new Envelope(
            subject: '[OTOMATIS] ' . $statusText . ' - ' . $this->capaian->no_tiket . ' - Kab/Kota ' . $this->capaian->wilayah,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.capaian_notification',
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

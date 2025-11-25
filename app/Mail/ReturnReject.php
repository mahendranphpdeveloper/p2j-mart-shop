<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReturnReject extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_data;
    public function __construct(array $mail_data)
    {
        $this->mail_data = $mail_data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Product Return Request Has Been Rejected',
        );
    }

    public function build()
    {
        return $this->subject('Your Product Return Request Has Been Rejected')
                    ->view('mail.return-rejected');
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

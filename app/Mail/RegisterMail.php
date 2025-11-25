<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;
    public $email;

    /**
     * Create a new message instance.
     */
    public function __construct($email)
    {
      $this->email = $email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
         $appName = config('app.name');
        return new Envelope(
            subject: 'Email verification for registration - '.$appName,
        );
    }

    /**
     * Get the message content definition.
     */

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
            // $email =  base64_encode($this->mail);
            $data =['email'=> $this->email];
            return $this->view('mail.register')->with($data);
    }

}

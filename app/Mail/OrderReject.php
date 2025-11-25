<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReject extends Mailable
{
    use Queueable, SerializesModels;

  public $reason;

    public function __construct( $reason)
    {
        $this->reason = $reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $appName = config('app.name');
        return new Envelope(
            subject: $appName.' - Order Cancelled',
);
    }


    public function content():  Content
    {
        return new Content(
            view: 'mail.order-rejected',
        );
    }

    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
            return $this->view('mail.order-rejected')->with(['data'=>$this->reason]);
    }
}

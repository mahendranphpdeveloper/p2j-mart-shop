<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserOrderMail extends Mailable
{
    use Queueable, SerializesModels;
    public $products;
    /**
     * Create a new message instance.
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
         $appName = config('app.name');
        return new Envelope(
            subject: 'Order Placed - '.$appName,
        );
    }

    /**
     * Get the message content definition.
     */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

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
            $data =['products'=> $this->products];
            return $this->view('mail.user-order')->with($data);
    }
}

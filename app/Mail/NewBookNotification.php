<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewBookNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $bookName;
    public $bookLink;

    public function __construct($bookName, $bookLink)
    {
        $this->bookName = $bookName;
        $this->bookLink = $bookLink;
    }

    public function build()
    {
        return $this->subject('New Book Added!')
                    ->view('emails.new_book_notification')
                    ->with([
                        'bookName' => $this->bookName,
                        'bookLink' => $this->bookLink,
                    ]);
    }
}

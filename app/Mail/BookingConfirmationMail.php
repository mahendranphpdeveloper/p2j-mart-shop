<?php


// app/Mail/BookingConfirmationMail.php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class BookingConfirmationMail extends Mailable
{
    public $summaryData;

    /**
     * Create a new message instance.
     *
     * @param  mixed  $summaryData
     * @return void
     */
    public function __construct($summaryData)
    {
        // Store the summary data to make it available in the email view
        $this->summaryData = $summaryData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Set the subject of the email and specify the view to be used for the email content
        return $this->subject('Booking Confirmation')
                    ->view('mail.booking_confirmation'); // This should be the Blade view for the email content
    }
}

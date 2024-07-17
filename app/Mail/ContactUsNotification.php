<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\ContactUs;

class ContactUsNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $contactus;

    /**
     * Create a new message instance.
     *
     * @param ContactUs $contactus
     */
    public function __construct(ContactUs $contactus)
    {
        $this->contactus = $contactus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Acknowledgement Email')
                    ->view('emails.contactUsNotification');
    }
}

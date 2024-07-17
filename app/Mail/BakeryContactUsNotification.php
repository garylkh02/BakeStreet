<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\BContactUs;

class BakeryContactUsNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $bakerycontactus;

    /**
     * Create a new message instance.
     *
     * @param BContactUs $bakerycontactus
     */
    public function __construct(BContactUs $bakerycontactus)
    {
        $this->bakerycontactus = $bakerycontactus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Acknowledgement Email')
                    ->view('emails.bakeryContactUs');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquiryStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $enquiry;
    public $type;

    /**
     * Create a new message instance.
     *
     * @param mixed $enquiry
     * @param string $type
     * @return void
     */
    public function __construct($enquiry, $type)
    {
        $this->enquiry = $enquiry;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->type === 'bakery') {
            return $this->view('emails.bakery_enquiry_status_update')
                        ->subject('Bakery Enquiry Status Update')
                        ->with(['enquiry' => $this->enquiry]);
        } else {
            return $this->view('emails.bakery_enquiry_status_update')
                        ->subject('Enquiry Status Update')
                        ->with(['enquiry' => $this->enquiry]);
        }
    }
}

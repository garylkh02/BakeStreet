<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\CakeCustomisation;

class CustomisationStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $customOrder;

    /**
     * Create a new message instance.
     *
     * @param CakeCustomisation $customOrder
     */
    public function __construct(CakeCustomisation $customOrder)
    {
        $this->customOrder = $customOrder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Cake Customisation Order Status')
                    ->view('emails.customiseStatusUpdate');
    }
}

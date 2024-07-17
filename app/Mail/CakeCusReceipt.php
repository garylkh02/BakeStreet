<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\CakeCustomisation;

class CakeCusReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $cake_customisations;

    /**
     * Create a new message instance.
     *
     * @param CakeCustomisation $cake_customisations
     */
    public function __construct(CakeCustomisation $cake_customisations)
    {
        $this->cake_customisations = $cake_customisations;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Order Receipt')
                    ->view('emails.customisationReceipt');
    }
}

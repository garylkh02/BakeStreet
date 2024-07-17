<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\CorporateOrder;

class CorporateOrderStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $corporateOrder;

    /**
     * Create a new message instance.
     *
     * @param CorporateOrder $corporateOrder
     */
    public function __construct(CorporateOrder $corporateOrder)
    {
        $this->corporateOrder = $corporateOrder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Corporate Order Status')
                    ->view('emails.corporateOrderStatus');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Application;

class ApplicationStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    /**
     * Create a new message instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Application Status Update';

        // Determine the view based on the application status
        if ($this->application->status === 'rejected') {
            return $this->subject($subject)
                        ->view('emails.rejectApplication');
        } else {
            return $this->subject($subject)
                        ->view('emails.applicationStatusUpdated');
        }
    }
}

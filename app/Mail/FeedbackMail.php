<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackMail extends Mailable
{
    use SerializesModels;

    public $feedback;

    public function __construct($feedback)
    {
        $this->feedback = $feedback;
    }

    public function build()
    {
        return $this->subject('Feedback Baru - FinTrack')
            ->view('emails.feedback');
    }
}

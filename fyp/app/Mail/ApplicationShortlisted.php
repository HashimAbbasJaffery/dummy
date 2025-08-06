<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationShortlisted extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $jobTitle;

    public function __construct($name, $jobTitle)
    {
        $this->name = $name;
        $this->jobTitle = $jobTitle;
    }

    public function build()
    {
        return $this->subject('You are shortlisted for ' . $this->jobTitle)
                    ->view('emails.shortlisted');
    }
}

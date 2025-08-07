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
    public $application;

    public function __construct($name, $jobTitle, $application)
    {
        $this->name = $name;
        $this->jobTitle = $jobTitle;
        $this->application = $application;
    }

    public function build()
    {
        return $this->subject('You are shortlisted for ' . $this->jobTitle)
                    ->view('emails.shortlisted');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationRejected extends Mailable
{
    use Queueable, SerializesModels;


    public $name;
    public $jobTitle;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $jobTitle)
    {
        $this->name = $name;
        $this->jobTitle = $jobTitle;
    }

   public function build() {
    
        return $this->subject('Application not accepted for ' . $this->jobTitle)
        ->view('emails.rejected');
   }
}

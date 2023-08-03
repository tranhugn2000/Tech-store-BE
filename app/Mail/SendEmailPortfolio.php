<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailPortfolio extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $email;
    public $description;
    
    public function __construct($name, $email, $description)
    {
        $this->name = $name;
        $this->email = $email;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.mail-contact')
                ->subject('NEW CONTACT FROM PORTFOLIO')
                ->with([
                    'name' => $this->name,
                    'email' => $this->email,
                    'description' => $this->description,
                ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class Notification extends Mailable
{
    use Queueable, SerializesModels;

	public $notification_content; 
	
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notification_content)
    {
        //
		$this->notification_content = $notification_content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notification');
    }
}

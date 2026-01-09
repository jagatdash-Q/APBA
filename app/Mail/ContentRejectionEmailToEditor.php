<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContentRejectionEmailToEditor extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(string $subject = 'Content Rejection', array $data = [])
    {
        $this->data = $data;
        $this->data['subject'] = $subject;
    }

    public function build()
    {
        return $this->subject($this->data['subject'] ?? 'Content Rejection')
            ->view('emails.generic')
            ->with('data', $this->data);
    }
}

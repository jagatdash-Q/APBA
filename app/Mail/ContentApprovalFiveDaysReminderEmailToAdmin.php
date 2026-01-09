<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContentApprovalFiveDaysReminderEmailToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(string $subject = 'Content Approval Reminder - 5 days', array $data = [])
    {
        $this->data = $data;
        $this->data['subject'] = $subject;
    }

    public function build()
    {
        return $this->subject($this->data['subject'] ?? 'Content Approval Reminder - 5 days')
            ->view('emails.generic')
            ->with('data', $this->data);
    }
}

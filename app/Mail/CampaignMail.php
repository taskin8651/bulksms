<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public $template;

    public function __construct(EmailTemplate $template)
    {
        $this->template = $template;
    }

    public function build()
    {
        return $this->subject($this->template->subject)
            ->view('emails.campaign')
            ->with([
                'body' => $this->template->body,
            ]);
    }
}

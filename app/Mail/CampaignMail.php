<?php

namespace App\Mail;

use App\Models\EmailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Contact;

class CampaignMail extends Mailable
{
   use Queueable, SerializesModels;

    public $template;
    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EmailTemplate $template, Contact $contact)
    {
        $this->template = $template;
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
public function build()
{
    return $this->subject($this->template->subject)
                ->view('emails.campaign')
                ->with([
                    'body' => $this->template->body,   // ✅ correct field
                    'contact' => $this->contact,
                ]);
}


}

<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Newsletter extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $image;
    public $link;

    public function __construct(string $content, ?string $image = null, ?string $link = null)
    {
        $this->content = $content;
        $this->image = $image;
        $this->link = $link;
    }

    public function build()
    {
        return $this->subject('نشرة بريدية جديدة')
                    ->view('emails.newsletter');
    }
}
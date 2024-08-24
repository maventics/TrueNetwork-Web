<?php

namespace App\Mail\emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class tradestart extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $investment;
    /**
     * Create a new message instance.
     */
    public function __construct($user,$investment)
    {
        $this->user=$user;
        $this->investment=$investment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Trade has been started',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.tradestart',
            with:([
            'user' => $this->user,
            'investment' => $this->investment,
            ])
                );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

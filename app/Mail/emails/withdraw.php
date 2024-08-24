<?php

namespace App\Mail\emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class withdraw extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $withdrawRequest;
    /**
     * Create a new message instance.
     */
    public function __construct($user,$withdrawRequest)
    {
        $this->user = $user;
        $this->withdrawRequest = $withdrawRequest;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Withdraw request has been Accepted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.withdraw',
            with:([
            'user' => $this->user,
            'withdrawRequest' => $this->withdrawRequest,
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

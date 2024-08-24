<?php

namespace App\Mail\emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class deposit extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $depositamount;
    /**
     * Create a new message instance.
     */
    public function __construct($user,$depositamount)
    {
        $this->user=$user;
        $this->depositamount=$depositamount;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your deposit request has been accepted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.deposit',
            with:([
            'user' => $this->user,
            'depositamount' => $this->depositamount,
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
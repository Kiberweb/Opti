<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\FeedBack as FeedBackModel;

class FeedBack extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Mail\FeedBack
     */
    private FeedBackModel $_feedback;

    /**
     * @var string
     */
    private string $_subject;

    /**
     * Create a new message instance.
     */
    public function __construct(FeedBackModel $feedBack, string $subject = 'Feed Back')
    {
        $this->_feedback = $feedBack;
        $this->_subject = $subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->_subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.feedback',
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
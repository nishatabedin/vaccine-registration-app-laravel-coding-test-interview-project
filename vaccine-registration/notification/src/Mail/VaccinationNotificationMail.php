<?php

namespace VaccineRegistration\Notification\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;
use VaccineRegistration\Common\DTO\NotificationDataDTO;

class VaccinationNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $messageContent;
    public $notificationData;

    /**
     * Create a new message instance.
     *
     * @param string $messageContent
     * @param NotificationDataDTO $notificationData
     */
    public function __construct(string $messageContent, NotificationDataDTO $notificationData)
    {
        $this->messageContent = $messageContent;
        $this->notificationData = $notificationData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vaccination Notification'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'notification::emails.notification' // Load the view from the Notification module
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

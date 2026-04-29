<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $invoices;
    public $type;
    public $settings;

    /**
     * Create a new message instance.
     */
    public function __construct($customer, $invoices, $type, $settings)
    {
        $this->customer = $customer;
        $this->invoices = $invoices;
        $this->type = $type;
        $this->settings = $settings;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = "Invoice Reminder - " . ($this->settings['company_name'] ?? 'ShivCore Micro Tech');
        if (count($this->invoices) > 1) {
            $subject .= " (Multiple Invoices Due)";
        } else {
            $subject .= " (Invoice #{$this->invoices[0]->invoice_no})";
        }

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reminder',
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

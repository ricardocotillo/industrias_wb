<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class QuoteFormMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The quote form data.
     *
     * @var array
     */
    public $data;

    /**
     * Create a new message instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->data['products'] = $this->processProducts($data['message']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cotización solicitada',
            from: new Address('atencionalcliente@filtroswillybusch.com.pe', 'Industrias Willy Busch'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.quote',
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

    /**
     * Process the products list from comma-separated message.
     *
     * @param string $message
     * @return array
     */
    private function processProducts(string $message): array
    {
        $products = explode(',', $message);
        return array_map(function ($product) {
            return trim($product);
        }, $products);
    }
}

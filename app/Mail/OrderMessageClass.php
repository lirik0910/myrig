<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class OrderMessageClass extends Mailable
{
    use Queueable, SerializesModels;

    protected $text;
    protected $number;

    public function __construct($number, $text)
    {
        $this->number = $number;
        $this->text = $text;
    }

    public function build()
    {
        return $this->view('emails.newMessage')
            ->with([
                'message' => $this->text,
                'number' => $this->number
            ])
            ->subject('Order ' . $this->number);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06.07.2018
 * Time: 15:10
 */

namespace App\Mail;


class OrderMessageClass
{
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
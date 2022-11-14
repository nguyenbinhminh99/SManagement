<?php

namespace App\Services\Mail;

use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendVerifyEmail {
    private $from = 'minhmocmeo0@gmail.com';
    private $fromName = 'Onschool';
    private $subject = 'Verify Email';

    public function handle(array $data)
    {
        Mail::send('mail', $data, function($message) use ($data) {
            $message->to($data['email'], $data['full_name'])->subject($this->subject);
            $message->from($this->from, $this->fromName);
        });
    }
}

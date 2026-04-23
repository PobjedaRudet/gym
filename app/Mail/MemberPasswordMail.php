<?php

namespace App\Mail;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $member;
    public $plainPassword;

    public function __construct(Member $member, string $plainPassword)
    {
        $this->member = $member;
        $this->plainPassword = $plainPassword;
    }

    public function build()
    {
        return $this->subject('Vaša lozinka za Gym Portal')
                    ->view('emails.member-password');
    }
}

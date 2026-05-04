<?php

namespace App\Mail;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $member;
    public $resetUrl;

    public function __construct(Member $member, string $resetUrl)
    {
        $this->member = $member;
        $this->resetUrl = $resetUrl;
    }

    public function build()
    {
        return $this->subject('Reset lozinke za Gym Portal')
            ->view('emails.member-reset-password');
    }
}

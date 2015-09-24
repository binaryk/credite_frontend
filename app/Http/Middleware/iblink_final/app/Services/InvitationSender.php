<?php

namespace App\Services;

use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Mail\Mailer;

class InvitationSender {

    protected $tokens;
    protected $mailer;

    public function __construct(TokenRepositoryInterface $tokens, Mailer $mailer) {
        $this->tokens = $tokens;
        $this->mailer = $mailer;
    }

    public function emailInvitationLink(CanResetPasswordContract $user, $institution, $student = false) {

        $data = [
            'user'        => $user,
            'name'        => $user->name,
            'type'        => $user->getOriginal('userable_type'),
            'inst_type'   => $institution->getOriginal('institutionable_type'),
            'institution' => $institution,
            'token'       => $this->tokens->create($user),
        ];

        if ($student) {
            $data['student'] = $student->user->name;
        }

        $this->mailer->send('emails.invitation', $data, function ($m) use ($user) {
            $m->to($user->getEmailForPasswordReset());
            $m->subject('Invitație pe platforma iBlink');
        });
    }
}

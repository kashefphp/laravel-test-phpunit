<?php


namespace kashefphp\TwoFactorAuth;


use Illuminate\Support\Facades\Notification;
use kashefphp\TwoFactorAuth\TokenStore\TokenStore\TokenGenerators\TokenGenerators\Notifications\LoginTokenNotification;

class TokenSender
{
    public function send($user, $token)
    {
        Notification::send($user, new LoginTokenNotification($token));
    }
}

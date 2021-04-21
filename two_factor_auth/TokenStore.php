<?php


namespace TwoFactorAuth;


class TokenStore
{

    public function saveToken($token, $userId): void
    {
        cache()->set($token . '2factor_auth' . $userId, 120);
    }
}

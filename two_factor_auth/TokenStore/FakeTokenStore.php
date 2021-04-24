<?php


namespace TwoFactorAuth\TokenStore;


class FakeTokenStore
{

    public function saveToken($token, $userId): void
    {
        //
    }
    public function getUidByToken($token)
    {
        $uid= cache()->pull($token . '_2factor_auth');
        return nullable($uid);
    }
}

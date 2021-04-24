<?php


namespace kashefphp\TwoFactorAuth\Authenticator;


use Illuminate\Support\Facades\Auth;

class SessionAuth
{

    public function check()
    {
        Auth::check();
    }
    public function loginById($uid)
    {
       \auth()->loginUsingId($uid);
    }
}

<?php


namespace TwoFactorAuth;


class TokenGenerator
{
    
    public function generateToken()
    {
        return random_int(1000000, 1000000 - 1);

    }

}

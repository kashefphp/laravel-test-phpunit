<?php


namespace kashefphp\TwoFactorAuth\TokenGenerators;


class FakeTokenGenerator
{

    public function generateToken()
    {

        return 123456;
    }

}

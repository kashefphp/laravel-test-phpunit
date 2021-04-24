<?php


namespace TwoFactorAuth\TokenGenerators;


class FakeTokenGenerator
{

    public function generateToken()
    {

        return 123456;
    }

}

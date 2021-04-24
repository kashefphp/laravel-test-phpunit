<?php


namespace TwoFactorAuth\TokenGenerators {


    class TokenGenerator
    {

        public function generateToken()
        {
            return random_int(1000000, 1000000 - 1);

        }

    }
}

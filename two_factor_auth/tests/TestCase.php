<?php


namespace kashefphp\TwoFactorAuth;


use kashefphp\TwoFactorAuth\TwoFactorAuthServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [TwoFactorAuthServiceProvider::class];
    }
}

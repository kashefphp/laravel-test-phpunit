<?php


namespace TwoFactorAuth\Facades;


use Illuminate\Support\Facades\Facade;

class TokenGeneratorFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'twoFactorAuth.tokenGenerator';
    }

    static function shouldProxyTo($class){
        app()->singleton(self::getFacadeAccessor(), $class);
    }
}

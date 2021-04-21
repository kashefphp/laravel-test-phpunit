<?php


namespace TwoFactorAuth\Facades;


use Illuminate\Support\Facades\Facade;

class TokenStoreFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'twoFactorAuth.tokenStore';
    }

    static function shouldProxyTo($class){
        app()->singleton(self::getFacadeAccessor(), $class);
    }
}

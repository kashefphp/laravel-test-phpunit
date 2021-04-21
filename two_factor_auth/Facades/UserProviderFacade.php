<?php


namespace TwoFactorAuth\Facades;


use Illuminate\Support\Facades\Facade;

class UserProviderFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'twoFactorAuth.userProvider';
    }

    static function shouldProxyTo($class){
        app()->singleton(self::getFacadeAccessor(), $class);
    }
}

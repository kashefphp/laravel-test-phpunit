<?php


namespace TwoFactorAuth\Http;


use Imanghafoori\SmartFacades\Facade;
use TwoFactorAuth\Http\Responses\AndriodResponses;
use TwoFactorAuth\Http\Responses\VueResponses;

class ResponderFacade extends Facade
{

//    public static function youShouldBeGuest()
//    {
//    }

    protected static function getFacadeAccessor()
    {

        if (request('client') == 'android')
        {
            return AndriodResponses::class;

        }
            return VueResponses::class;

    }






//static function shouldProxyTo($class)
//{
//    app()->singleton(self::getFacadeAccessor(), $class);
//}
}

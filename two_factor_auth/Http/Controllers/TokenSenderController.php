<?php


namespace TwoFactorAuth\Http\Controllers;


use http\Client\Curl\User;
use Illuminate\Routing\Controller;
use TwoFactorAuth\Facades\TokenGeneratorFacade;
use TwoFactorAuth\Facades\TokenStoreFacade;
use TwoFactorAuth\Facades\UserProviderFacade;
use TwoFactorAuth\Http\ResponderFacade;
use TwoFactorAuth\TokenGenerator;
use TwoFactorAuth\TokenStore;

class TokenSenderController extends Controller
{


    public function issueToken()
    {
        $email= request('email');

        $user = UserProviderFacade::getUserByEmail($email);

        if (UserProviderFacade::isBanned($user->id)) {
            return ResponderFacade::blockUser();
        }
        $token = TokenGeneratorFacade::generateToken();

        TokenStoreFacade::saveToken($token, $user->id);

        return ResponderFacade::tokenSend();
    }

}

<?php


namespace TwoFactorAuth\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use TwoFactorAuth\Facades\AuthFacade;
use TwoFactorAuth\Facades\TokenGeneratorFacade;
use TwoFactorAuth\Facades\TokenSenderFacade;
use TwoFactorAuth\Facades\TokenStoreFacade;
use TwoFactorAuth\Facades\UserProviderFacade;
use TwoFactorAuth\Http\ResponderFacade;

class TokenSenderController extends Controller
{


    public function issueToken()
    {
        $email= request('email');
        $this->validateEmailIsValid();
        $this->checkUserIsGuest();

        /**
         * @var \Imanghafoori\Helpers\Nullable $user
         */
        $user = UserProviderFacade::getUserByEmail($email)->getOrSend(
            [ResponderFacade::class, 'userNotFound']
        );

        if (UserProviderFacade::isBanned($user->id)) {
            return ResponderFacade::blockUser();
        }
        $token = TokenGeneratorFacade::generateToken();

        TokenStoreFacade::saveToken($token, $user->id);

        TokenSenderFacade::send($token, $user);

        return ResponderFacade::tokenSend();
    }

    private function validateEmailIsValid(): void
    {
        $obj_val = Validator::make(request()->all(), ['email' => 'email|required']);
        if ($obj_val->fails()) {
            ResponderFacade::emailNotValid()->throwResponse();
        }
    }

    private function checkUserIsGuest(): void
    {
        if (AuthFacade::check()) {
            ResponderFacade::youShouldBeGuest()->throwResponse();
        }
    }

    public function loginWithToken()
    {
        $token= request('token');
        $uid= TokenStoreFacade::getUidByToken($token)->getOrSend(
            [ResponderFacade::class, 'tokenNotFound']
        );

        AuthFacade::loginById($uid);
        return ResponderFacade::loggedIn();
    }

}

<?php

use App\Models\User;
use TwoFactorAuth\TokenStore\TokenStore\TokenGenerators\TokenGenerators\Facades\TokenSenderFacade;
use TwoFactorAuth\TokenStore\TokenStore\TokenGenerators\TokenGenerators\Facades\TokenStoreFacade;


Route::get('/two-factor-auth/request-token',
    'TokenSenderController@issueToken')
    ->name('2factor.requestToken');

Route::get('/two-factor-auth/login',
    'TokenSenderController@loginWithToken')
    ->name('2factor.login');

if (app()->environment('local')) {
    Route::get('test/token-notification', function () {
        User::unguard();
        $data = ['id' => 1, 'email' => 'kashefymajid1992@gmail.com'];
        $user = new User($data);
        TokenSenderFacade::send($user, '123456');
    });

    Route::get('test/token-storage', function () {
        config()->set('two_factor_config.token_ttl', 3);
        TokenStoreFacade::saveToken('1q2w3e', 2);
        sleep(1);
        $uid = TokenStoreFacade::getUidByToken('1q2w3e')->getOr(null);
        if ($uid != 2) {
            dd('some problems');
        }
        $uid = TokenStoreFacade::getUidByToken('1q2w3e')->getOr(null);
        if (!is_null($uid)) {
            dd('some problem');
        }


        config()->set('two_factor_config.token_ttl', 1);
        TokenStoreFacade::saveToken('1q2w3e4', 2);
        sleep(1.5);
        $uid = TokenStoreFacade::getUidByToken('1q2w3e4')->getOr(null);
        if (!is_null($uid)) {
            dd('some problem');
        }
        dd('every thing is ok');
    });


}


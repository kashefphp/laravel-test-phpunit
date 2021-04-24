<?php

namespace TwoFactorAuth\tests;

use App\Models\User;
use Tests\TestCase;
use TwoFactorAuth\Facades\AuthFacade;
use TwoFactorAuth\Facades\TokenGeneratorFacade;
use TwoFactorAuth\Facades\TokenSenderFacade;
use TwoFactorAuth\Facades\TokenStoreFacade;
use TwoFactorAuth\Facades\UserProviderFacade;
use TwoFactorAuth\Http\ResponderFacade;

class TwoFactorAuthTokenTest extends TestCase
{
    public function test_the_happy_path()
    {
//        $this->withoutExceptionHandling();
        User::unguard();
        UserProviderFacade::shouldReceive('isBanned')
            ->once()
            ->with(1)
            ->andReturn(false);

        $user = new User(['id' => 1, 'email' => 'majid@gmail.com']);
        UserProviderFacade::shouldReceive('getUserByEmail')
            ->once()
            ->with('majid@gmail.com')
            ->andReturn(nullable($user));

        TokenGeneratorFacade::shouldReceive('generateToken')
            ->once()
            ->withNoArgs()
            ->andReturn('11qqa');

        TokenStoreFacade::shouldReceive('saveToken')
            ->once()
            ->with('11qqa', $user->id);

        TokenSenderFacade::shouldReceive('send')
            ->once()
            ->with('11qqa', $user);

        ResponderFacade::shouldReceive('tokenSend')->once();
        $this->get('/api/two-factor-auth/request-token?email=majid@gmail.com');

    }

    public function test_android_responses()
    {
//        $this->withoutExceptionHandling();
        User::unguard();

        UserProviderFacade::shouldReceive('isBanned')
            ->andReturn(false);

        $user = new User(['id' => 1, 'email' => 'majid@gmail.com']);
        UserProviderFacade::shouldReceive('getUserByEmail')
            ->andReturn(nullable($user));

        $respon = $this->get('/api/two-factor-auth/request-token?email=majid@gmail.com&client=android');
        $respon->assertJson(['msg' => 'token was send to ur app.']);

    }

    public function test_user_is_banned()
    {
        User::unguard();

        UserProviderFacade::shouldReceive('isBanned')
            ->once()
            ->with(1)
            ->andReturn(true);

        $user = new User(['id' => 1, 'email' => 'majid@gmail.com']);
        UserProviderFacade::shouldReceive('getUserByEmail')
            ->once()
            ->with('majid@gmail.com')
            ->andReturn(nullable($user));

        TokenGeneratorFacade::shouldReceive('generateToken')
            ->never();

        TokenStoreFacade::shouldReceive('saveToken')
            ->never();

        TokenSenderFacade::shouldReceive('send')
            ->never();

        $respon = $this->get('/api/two-factor-auth/request-token?email=majid@gmail.com');
        $respon->assertStatus(400);
        $respon->assertJson(['error' => 'you are blocked']);
    }

    public function test_email_does_not_exists()
    {
        UserProviderFacade::shouldReceive('getUserByEmail')
            ->once()
            ->with('majid@gmail.com')
            ->andReturn(nullable(null));
        UserProviderFacade::shouldReceive('isBanned')->never();
        TokenGeneratorFacade::shouldReceive('generateToken')->never();
        TokenStoreFacade::shouldReceive('saveToken')->never();
        TokenSenderFacade::shouldReceive('send')->never();
        ResponderFacade::shouldReceive('userNotFound')->once()
        ->andReturn(response('hello'));
        $resp= $this->get('/api/two-factor-auth/request-token?email=majid@gmail.com');
        $resp->assertSee('hello');
    }

    public function test_email_not_valid()
    {
        UserProviderFacade::shouldReceive('getUserByEmail')
            ->never();
        UserProviderFacade::shouldReceive('isBanned')->never();
        TokenGeneratorFacade::shouldReceive('generateToken')->never();
        TokenStoreFacade::shouldReceive('saveToken')->never();
        TokenSenderFacade::shouldReceive('send')->never();
        ResponderFacade::shouldReceive('emailNotValid')->once()
            ->andReturn(response('hello'));
        $resp= $this->get('/api/two-factor-auth/request-token?email=majid%%%gmail.com');
        $resp->assertSee('hello');
    }

    public function test_user_is_guest()
    {
//        $this->withoutExceptionHandling();
        AuthFacade::shouldReceive('check')->once()->andReturn(true);
        UserProviderFacade::shouldReceive('getUserByEmail')
            ->never();
        UserProviderFacade::shouldReceive('isBanned')->never();
        TokenGeneratorFacade::shouldReceive('generateToken')->never();
        TokenStoreFacade::shouldReceive('saveToken')->never();
        TokenSenderFacade::shouldReceive('send')->never();
        ResponderFacade::shouldReceive('youShouldBeGuest')->once()->andReturn(response('hello'));
        $resp= $this->get('/api/two-factor-auth/request-token?email=majid@gmail.com');
        $resp->assertSee('hello');
    }
}

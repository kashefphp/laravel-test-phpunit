<?php
namespace TwoFactorAuth\tests;

use App\Models\User;
use Tests\TestCase;
use TwoFactorAuth\Facades\TokenGeneratorFacade;
use TwoFactorAuth\Facades\TokenStoreFacade;
use TwoFactorAuth\Facades\UserProviderFacade;
use TwoFactorAuth\Http\ResponderFacade;

class TwoFactorAuthTokenTest extends TestCase
{
    public function test_sample()
    {
//        $this->withoutExceptionHandling();
        User::unguard();

        UserProviderFacade::shouldReceive('isBanned')
            ->once()
            ->with(1 )
            ->andReturn(false);

        UserProviderFacade::shouldReceive('getUserByEmail')
            ->once()
            ->with('majid@gmail.com')
            ->andReturn($user=new User(['id'=>1, 'email'=>'majid@gmail.com']));

        TokenGeneratorFacade::shouldReceive('generateToken')
            ->once()
            ->withNoArgs()
            ->andReturn('11qqa');

        TokenStoreFacade::shouldReceive('saveToken')
            ->once()
        ->with('11qqa', $user->id);

        ResponderFacade::shouldReceive('tokenSend')->once();
        $this->get('/api/two-factor-auth/request-token?email=majid@gmail.com');

    }

    public function test_android_responses()
    {
//        $this->withoutExceptionHandling();
        User::unguard();

        UserProviderFacade::shouldReceive('isBanned')
            ->once()
            ->with(1 )
            ->andReturn(false);

        UserProviderFacade::shouldReceive('getUserByEmail')
            ->once()
            ->with('majid@gmail.com')
            ->andReturn($user=new User(['id'=>1, 'email'=>'majid@gmail.com']));

        TokenGeneratorFacade::shouldReceive('generateToken')
            ->once()
            ->withNoArgs()
            ->andReturn('11qqa');

        TokenStoreFacade::shouldReceive('saveToken')
            ->once()
        ->with('11qqa', $user->id);


        $respon= $this->get('/api/two-factor-auth/request-token?email=majid@gmail.com&client=android');
        $respon->assertJson(['msg' => 'token was send to ur app.']);

    }

    public function test_user_is_banned()
    {
        User::unguard();

        UserProviderFacade::shouldReceive('isBanned')
            ->once()
            ->with(1 )
            ->andReturn(true);

        UserProviderFacade::shouldReceive('getUserByEmail')
            ->once()
            ->with('majid@gmail.com')
            ->andReturn($user=new User(['id'=>1, 'email'=>'majid@gmail.com']));

        TokenGeneratorFacade::shouldReceive('generateToken')
            ->never();

        TokenStoreFacade::shouldReceive('saveToken')
            ->never();

        $respon= $this->get('/api/two-factor-auth/request-token?email=majid@gmail.com');
        $respon->assertStatus(400);
        $respon->assertJson(['error'=>'you are blocked']);
    }
}

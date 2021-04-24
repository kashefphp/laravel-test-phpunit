<?php


namespace TwoFactorAuth;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use TwoFactorAuth\Authenticator\SessionAuth;
use TwoFactorAuth\Facades\AuthFacade;
use TwoFactorAuth\Facades\TokenGeneratorFacade;
use TwoFactorAuth\Facades\TokenSenderFacade;
use TwoFactorAuth\Facades\TokenStoreFacade;
use TwoFactorAuth\Facades\UserProviderFacade;
use TwoFactorAuth\TokenGenerators\FakeTokenGenerator;
use TwoFactorAuth\TokenGenerators\TokenGenerator;
use TwoFactorAuth\TokenStore\FakeTokenStore;
use TwoFactorAuth\TokenStore\TokenStore;


class TwoFactorAuthServiceProvider extends ServiceProvider
{
    private $namespace = 'TwoFactorAuth\Http\Controllers';

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/two_factor_auth_config.php', 'two_factor_config');
        AuthFacade::shouldProxyTo(SessionAuth::class);
        UserProviderFacade::shouldProxyTo(UserProvider::class);
        if (app()->runningUnitTests()) {
            $tokenGenerator = FakeTokenGenerator::class;
            $tokenStore = FakeTokenStore::class;
            $tokenSender = FakeTokenSender::class;
        } else {
            $tokenGenerator = TokenGenerator::class;
            $tokenStore = TokenStore::class;
            $tokenSender = TokenSender::class;
        }
        TokenGeneratorFacade::shouldProxyTo($tokenGenerator);
        TokenStoreFacade::shouldProxyTo($tokenStore);
        TokenSenderFacade::shouldProxyTo($tokenSender);
    }

    public function boot()
    {
        if (! ($this->app->routesAreCached())) {
            $this->defineRoutes();
        }
    }

    private function defineRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . './routes.php');
    }

}

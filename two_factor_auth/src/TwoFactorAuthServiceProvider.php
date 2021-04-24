<?php


namespace kashefphp\TwoFactorAuth;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use kashefphp\TwoFactorAuth\Authenticator\SessionAuth;
use kashefphp\TwoFactorAuth\Facades\AuthFacade;
use kashefphp\TwoFactorAuth\Facades\TokenGeneratorFacade;
use kashefphp\TwoFactorAuth\Facades\TokenSenderFacade;
use kashefphp\TwoFactorAuth\Facades\TokenStoreFacade;
use kashefphp\TwoFactorAuth\Facades\UserProviderFacade;
use kashefphp\TwoFactorAuth\TokenGenerators\FakeTokenGenerator;
use kashefphp\TwoFactorAuth\TokenGenerators\TokenGenerator;
use kashefphp\TwoFactorAuth\TokenStore\FakeTokenStore;
use kashefphp\TwoFactorAuth\TokenStore\TokenStore;


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

<?php


namespace TwoFactorAuth;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use TwoFactorAuth\Facades\TokenGeneratorFacade;
use TwoFactorAuth\Facades\TokenStoreFacade;
use TwoFactorAuth\Facades\UserProviderFacade;
use TwoFactorAuth\Http\ResponderFacade;
use TwoFactorAuth\Http\Responses\AndriodResponses;
use TwoFactorAuth\Http\Responses\VueResponses;

class TwoFactorAuthServiceProvider extends ServiceProvider
{
    private $namespace = 'TwoFactorAuth\Http\Controllers';

    public function register()
    {
        UserProviderFacade::shouldProxyTo(UserProvider::class);
        TokenGeneratorFacade::shouldProxyTo(TokenGenerator::class);
        TokenStoreFacade::shouldProxyTo(TokenStore::class);
    }

    public function boot()
    {
        $this->defineRoutes();
    }

    private function defineRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . './routes.php');
    }

}

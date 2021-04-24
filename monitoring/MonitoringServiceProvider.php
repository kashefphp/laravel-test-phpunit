<?php


namespace Monitoring;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use TwoFactorAuth\Http\ResponderFacade;

class MonitoringServiceProvider extends ServiceProvider
{

    public function boot()
    {
        ResponderFacade::preCall('tokenNotFound', function (){
            Log::info('invalid token request');
        });
    }
}

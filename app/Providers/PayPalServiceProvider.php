<?php

namespace App\Providers;

use Config;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class PayPalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {

        $clientID = Setting::where('parameter_name', 'paypal_client_id')->where('status', 1)->first() ? Setting::where('parameter_name', 'paypal_client_id')->where('status', 1)->first()->parameter_value : '';
        $secret = Setting::where('parameter_name', 'paypal_secret')->where('status', 1)->first() ? Setting::where('parameter_name', 'paypal_secret')->where('status', 1)->first()->parameter_value : '';
        $env = Setting::where('parameter_name', 'paypal_env')->where('status', 1)->first() ? Setting::where('parameter_name', 'paypal_env')->where('status', 1)->first()->parameter_value : '';
    
        $config = array(

            'client_id'  => $clientID,
            'secret'     => $secret,
            'settings'   => array('mode' => $env, 'http.ConnectionTimeOut' => 30, 'log.LogEnabled' => true, 'log.FileName' => storage_path() . '/logs/paypal.log', 'log.LogLevel' => 'ERROR'),
        );

        Config::set('paypal', $config);
    }
}

<?php

namespace lucasgiovanny\SmsDev;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;
use lucasgiovanny\SmsDev\SmsDev;
use lucasgiovanny\SmsDev\SmsDevChannel;

class SmsDevServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->when(SmsDevChannel::class)->needs(SmsDev::class)->give(function () {
            $apiKey = config('services.smsdev.api_key');
            return new SmsDev($apiKey, new HttpClient());
        });
    }

    public function register()
    {
    }
}

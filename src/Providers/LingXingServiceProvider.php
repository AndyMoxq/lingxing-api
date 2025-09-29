<?php

namespace ThankSong\LingXing\Providers;

use Illuminate\Support\ServiceProvider;
use ThankSong\LingXing\LingXing;

class LingXingServiceProvider extends ServiceProvider{
    public function boot(){
        $this->publishes([
            __DIR__.'/../../config/lingxing.php' => config_path('lingxing.php'),
        ], 'lingxing');
        
    }

    public function register(){
        $this->mergeConfigFrom(
            __DIR__.'/../../config/lingxing.php',
            'lingxing'
        );
        $this->app->singleton('lingxing', fn() => new LingXing);
    }
}
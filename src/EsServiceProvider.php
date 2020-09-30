<?php

namespace Zwen\EsOrm;

use Illuminate\Support\ServiceProvider;

class EsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
		$this->publishes([
			__DIR__ . '/config/elasticsearch.php' => config_path('elasticsearch.php'),
		]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('es', function(){
            return new EsManager($this->app);
        });
    }
}

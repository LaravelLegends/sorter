<?php

namespace LaravelLegends\Sorter;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class SorterProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {   

        $this->app['config']->package('laravellegends/sorter', __DIR__ . '/../config');
       
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $app = $this->app;

        $this->app->bind('sorter', function ($app) {

            $index = $app['config']->get('sorter::index');
            
            $directionIndex = $app['config']->get('sorter::direction_index');


            return new Sorter(
                $app['url'], $app['html'], $app['request'], $index, $directionIndex
            );
        });

    }
}

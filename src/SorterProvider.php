<?php

namespace PHPLegends\ColumnSorter;

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
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Sorter::class, function () use ($app)
        {
            $prefix = $app['config']->get('column-sorter::config.index');

            $sorter = new Sorter($app['url'], $prefix);

            $app['request']->query($index, 'asc');

        });
    }
}

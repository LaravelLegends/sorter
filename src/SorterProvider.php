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
            $index = $app['config']->get('column-sorter::config.index');

            $sorter = new Sorter($app['url'], $index);
            
            $directionIndex = $app['config']->get('column-sorter::config.direction_index');

            $direction = $app['request']->query($directionIndex, 'asc');

            $sorter->setDirection($direction);

            return $sorter;

        });
    }
}

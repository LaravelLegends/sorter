<?php

namespace PHPLegends\SorterLaravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class SorterProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {   

        $this->registryMacros();

        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('laravel-sorter.php'),
        ], 'config');
       
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php',
            'laravel-sorter'
        );

        $app = $this->app;

        $this->app->bind(Sorter::class, function ($app) {

            $index = config('laravel-sorter.index');
            
            $directionIndex = config('laravel-sorter.direction_index');

            $sorter = new Sorter($app['url'], $app['html'], $index, $directionIndex);
            
            $sorter->setDirection(
                request($sorter->getDirectionIndex())
            );

            $sorter->setCurrentField(
                request($sorter->getFieldIndex())
            );

            return $sorter;

        });

    }

    protected function registryMacros()
    {
        $app = $this->app;

        Builder::macro('orderBySorter', function (array $acceptedFields = []) use($app)
        {
            $sorter = $app[Sorter::class];

            $field = $sorter->getCurrentField();

            if ($field && $sorter->acceptedField($acceptedFields))
            {
                $this->orderBy($field, $sorter->getDirection());
            }

            return $this;
        });
    }
}

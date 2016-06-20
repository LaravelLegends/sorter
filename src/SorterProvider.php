<?php

namespace LaravelLegends\Sorter;

use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
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

            $fieldIndex = config('laravel-sorter.index');
            
            $directionIndex = config('laravel-sorter.direction_index');

            return $sorter = new Sorter(
                $app['url'], $app['html'], $app['request'], $fieldIndex, $directionIndex
            );

        });

    }

    /**
     * Registry a macro for Builder
     * 
     * */
    protected function registryMacros()
    {
        $sorter = $this->app[Sorter::class];

        Builder::macro('orderBySorter', function (array $whiteList = []) use ($sorter) {

            $field = $sorter->getCurrentField();

            if (! $field) return $this;

            if (! $sorter->checkCurrentByWhitelist($whiteList)) {

                $message = "Field '{$field}' is not defined in whitelist";

                throw new \UnexpectedValueException($message);
            }

            $this->orderBy($field, $sorter->getDirection());

            return $this;
        });
    }
}

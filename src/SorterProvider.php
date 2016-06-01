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

        $this->package('laravellegends/sorter');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $app = $this->app;

        $this->app->bind(Sorter::class, function ($app) {

            $index = config('laravel-sorter.index');
            
            $directionIndex = config('laravel-sorter.direction_index');

            $sorter = new Sorter($app['url'], $app['html'], $index, $directionIndex);
            
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

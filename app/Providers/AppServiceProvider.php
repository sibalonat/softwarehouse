<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // converts a collection to a remapped label/value array
        Collection::macro('toLabelValueArray', function (string $label_field, string $value_field) {
            return $this->map(function ($value) use ($label_field, $value_field) {
                return ['label' => $value->$label_field, 'value' => $value->$value_field];
            })->prepend(['label' => null, 'value' => null]);
        });
    }
}

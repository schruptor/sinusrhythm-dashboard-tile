<?php

namespace Schruptor\Sinusrhythm;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;
use Schruptor\Sinusrhythm\Commands\FetchStatusCommand;

class SinusrhythmTileServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([FetchStatusCommand::class]);
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dashboard-sinusrhythm-tile'),
        ], 'dashboard-sinusrhythm-tile-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-sinusrhythm-tile');

        Livewire::component('sinusrhythm-tile', SinusrhythmTileComponent::class);
    }
}

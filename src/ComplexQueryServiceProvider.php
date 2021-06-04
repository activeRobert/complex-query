<?php

namespace ActiveLogic\ComplexQuery;

use Illuminate\Support\ServiceProvider;

class ComplexQueryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeQueryCommand::class,
            ]);
        }
    }
}

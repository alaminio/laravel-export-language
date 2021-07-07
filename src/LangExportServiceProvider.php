<?php


namespace Topup\LangExport;

use Illuminate\Support\ServiceProvider;


class LangExportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'topup-export-lang');
    }

    public function register()
    {
        //
    }
}
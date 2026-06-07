<?php

namespace Alkoumi\LaravelArabicTafqeet;

use Illuminate\Support\ServiceProvider;

class LaravelArabicTafqeetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if (class_exists(\Illuminate\Foundation\AliasLoader::class)) {
            \Illuminate\Foundation\AliasLoader::getInstance()->alias('Tafqeet', Tafqeet::class);
        }

        // For Laravel 11+ the alias is registered via extra.laravel.aliases
        // in composer.json, so this block is a backward-compat fallback.
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        //
    }
}

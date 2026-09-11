<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || env('VERCEL')) {
            $this->app->useStoragePath('/tmp/storage');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || env('VERCEL')) {
            $dirs = [
                '/tmp/storage/framework/views',
                '/tmp/storage/framework/sessions',
                '/tmp/storage/framework/cache',
                '/tmp/storage/framework/cache/data',
                '/tmp/storage/logs',
                '/tmp/views',
            ];
            foreach ($dirs as $dir) {
                if (!is_dir($dir)) {
                    @mkdir($dir, 0755, true);
                }
            }
        }
    }
}

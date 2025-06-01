<?php

namespace App\Providers;

use App\Helpers\ObjectHelper;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Chargement automatique des helpers
        foreach (glob(app_path('Helpers') . '/*.php') as $file) {
            require_once $file;
        }
        
        // Enregistrement de la façade ObjectHelper
        $this->app->bind('object-helper', function () {
            return new ObjectHelper();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Chargement des alias personnalisu00e9s
        $aliases = config('aliases');
        if (is_array($aliases)) {
            $loader = AliasLoader::getInstance();
            foreach ($aliases as $alias => $class) {
                $loader->alias($alias, $class);
            }
        }
    }
}

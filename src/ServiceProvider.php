<?php

namespace TelcoLAB\Minify;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();

        $enabled = $this->app->config->get('minify.enabled');

        if ($enabled) {
            $this->extendBladeCompiler();
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/minify.php', 'minify'
        );
    }

    /**
     * Publish the config.
     *
     * @return void
     */
    protected function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/minify.php' => config_path('minify.php'),
        ], 'minify.config');
    }

    /**
     * Extend Laravel's blade compiler.
     *
     * @return void
     */
    public function extendBladeCompiler()
    {
        $ignoredPaths = $this->app->config->get('minify.ignore');

        Blade::extend(function ($view, $compiler) use ($ignoredPaths) {
            if ($ignoredPaths) {
                $path = str_replace('\\', '/', $compiler->getPath());

                foreach ($ignoredPaths as $ignoredPath) {
                    if (strpos($path, $ignoredPath) !== false) {
                        return $view;
                    }
                }
            }

            $minifier = new Minifier($view);

            return $minifier->render();
        });
    }
}

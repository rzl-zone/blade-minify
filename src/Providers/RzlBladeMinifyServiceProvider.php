<?php

namespace RzlZone\BladeMinify\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use RzlZone\BladeMinify\BladeCompiler\IgnoreMinifyBladeCompiler;
use RzlZone\BladeMinify\RzlBladeMinify;

class RzlBladeMinifyServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap the application services.
   */
  public function boot(): void
  {
    if ($this->app->runningInConsole()) {
      $this->publishes([
        __DIR__ . '/../config/config.php' => config_path('rzlzone-blade-minify.php'),
      ], 'RzlZoneBladeMinify');
    }

    /** @var IgnoreMinifyBladeCompiler $compiler */
    $compiler = app('blade.compiler');

    Blade::directive('ignoreRzlzoneMinify', function ($expression) use ($compiler) {
      return $compiler->compileExcludeMinify($expression);
    });

    Blade::directive('endIgnoreRzlzoneMinify', function ($expression) use ($compiler) {
      return $compiler->compileEndExcludeMinify($expression);
    });
  }

  /**
   * Register the application services.
   */
  public function register(): void
  {
    $this->registerOptionalProviders();

    $this->app->singleton('blade.compiler', function ($app) {
      return new IgnoreMinifyBladeCompiler($app['files'], $app['config']['view.compiled']);
    });

    // Automatically apply the package configuration
    $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'rzlzone-blade-minify');

    // Register the main class to use with the facade
    $this->app->singleton(RzlBladeMinify::class);

    $router = $this->app->make(\Illuminate\Routing\Router::class);

    $router->middleware('RzlBladeOutputMinifier', \RzlZone\BladeMinify\Middleware\RzlBladeOutputMinifier::class);

    $router->aliasMiddleware('RzlBladeOutputMinifier', \RzlZone\BladeMinify\Middleware\RzlBladeOutputMinifier::class);
    $router->pushMiddlewareToGroup('web', \RzlZone\BladeMinify\Middleware\RzlBladeOutputMinifier::class);
  }

  protected function registerOptionalProviders(): void
  {
    if (class_exists(\Illuminate\Foundation\Vite::class)) {
      $this->app->register(
        \RzlZone\BladeMinify\Providers\CustomViteProvider::class
      );
    }
  }
}

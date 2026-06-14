<?php

namespace RzlZone\BladeMinify\Providers;

use Illuminate\Foundation\Vite ;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use RzlZone\BladeMinify\VendorRewrites\Laravel\Vite\ViteCustom;

class ViteCustomProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    $this->app->singleton(Vite::class, fn () => $this->makeVite());

    $this->app->alias(
      Vite::class,
      ViteCustom::class
    );
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    // Blade directive

    if ($this->app->resolved('blade.compiler')) {
      $this->registerDirective(
        $this->app->make(BladeCompiler::class)
      );

      return;
    }

    $this->app->afterResolving(
      'blade.compiler',
      function (BladeCompiler $bladeCompiler) {
        $this->registerDirective($bladeCompiler);
      }
    );
  }

  protected function makeVite(): ViteCustom
  {
    $vite = (new ViteCustom())
        ->useBuildDirectory(config('app.build_dir'))
        ->useManifestFilename(config('app.manifest_name'));

    if (config('app.app_use_nonce')) {
      $vite->useCspNonce();
    }

    if ($hot = config('app.hot_file')) {
      if (is_file($hot)) {
        $vite
            ->useHotFile($hot)
            ->createAssetPathsUsing(
              fn (string $path) => "/{$path}"
            );
      }
    }

    return $vite;
  }

  protected function registerDirective(BladeCompiler $bladeCompiler)
  {
    $bladeCompiler->directive('vite', function ($expression) {
      return "<?php echo app(\\RzlZone\\BladeMinify\\VendorRewrites\\Laravel\\Vite\\ViteCustom::class)(
            {$expression},
            config('app.build_dir')
        ); ?>";
    });

    $bladeCompiler->directive('viteReactRefresh', function ($expression) {
      return "<?php echo app(\\RzlZone\\BladeMinify\\VendorRewrites\\Laravel\\Vite\\ViteCustom::class)
        ->useHotFileRefresh({$expression})
        ->reactRefresh({$expression}); ?>";
    });
  }
}

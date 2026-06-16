<?php

namespace RzlZone\BladeMinify\Providers;

use Illuminate\Foundation\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use RzlZone\BladeMinify\VendorRewrites\Laravel\Vite\CustomVite;

class CustomViteProvider extends ServiceProvider
{
  /** Register services. */
  public function register(): void
  {
    $this->app->singleton(Vite::class, fn () => $this->makeVite());

    $this->app->alias(
      Vite::class,
      CustomVite::class
    );
  }

  /** Bootstrap services. */
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

  protected function makeVite(): CustomVite
  {
    $vite = (new CustomVite())
        ->useBuildDirectory()
        ->useManifestFilename();

    $vite->useCspNonce();

    if ($hot = config('rzlzone-blade-minify.custom-vite.hot_file')) {
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
    // Resolve class FQN outside the string boundary to enable IDE refactor tracking
    $viteClass = CustomVite::class;

    // Register the primary asset compiler directive using clean concatenation
    $bladeCompiler->directive('vite', function ($expression) use ($viteClass) {
      return '<?php echo app(' . $viteClass . '::class)(' . $expression . '); ?>';
    });

    // Register the React hot-reloading preamble compiler directive with visible methods
    $bladeCompiler->directive('viteReactRefresh', function ($expression) use ($viteClass) {
      return '<?php echo app(' . $viteClass . '::class)->reactRefresh' . '(' . $expression . '); ?>';
    });
  }
}

<?php

declare(strict_types=1);

namespace RzlZone\BladeMinify\Providers;

use Illuminate\Routing\Router;
use Laravel\Boost\BoostServiceProvider as BaseBoostServiceProvider;
use RzlZone\BladeMinify\VendorRewrites\Laravel\Boost\InjectBoostMiddleware;

class BoostServiceProvider extends BaseBoostServiceProvider
{
  protected function hookIntoResponses(Router $router): void
  {
    $this->app->booted(function () use ($router): void {
      $router->pushMiddlewareToGroup(
        'web',
        InjectBoostMiddleware::class
      );
    });
  }
}

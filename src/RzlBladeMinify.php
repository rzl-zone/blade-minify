<?php

namespace RzlZone\BladeMinify;

use Illuminate\Support\Facades\Facade;
use RzlZone\BladeMinify\Minifier\RzlBladeMinifier;

class RzlBladeMinify extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor(): string
  {
    return RzlBladeMinifier::class;
  }
}

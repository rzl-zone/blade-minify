<?php

namespace RzlZone\BladeMinify\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RzlZone\BladeMinify\RzlBladeMinify;

class RzlBladeOutputMinifier
{
  /**
   * @param Request $request
   * @param Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next): mixed
  {
    /** @var Response */
    $response = $next($request);

    if (
      $this->isResponseObject($response)
      && $this->isResponseHtml($response)
      && !$this->isIgnoredRoute($request)
    ) {
      $html = str($response->getContent())->toString();

      $content = null;

      if (!config('rzlzone-blade-minify.enable')) {
        $content = RzlBladeMinify::disableMinify($html);
      } elseif (config('rzlzone-blade-minify.run_production_only') && !app()->isProduction()) {
        $content = RzlBladeMinify::disableMinify($html);
      } else {
        if (!app()->isProduction()) {
          $html = str($html)->replace(["%5B", "%5D"], ["[", "]"])->toString();
        }
        $content = RzlBladeMinify::minify($html);
      }

      $response->setContent($content);
    }

    return $response;
  }

  /**
  * @param Response $response
  * @return bool
  */
  protected function isResponseObject($response): bool
  {
    return is_object($response) && $response instanceof \Symfony\Component\HttpFoundation\Response;
  }

  /**
  * @param \Symfony\Component\HttpFoundation\Response $response
  * @return bool
  */
  protected function isResponseHtml($response): bool
  {
    if (! $response instanceof \Symfony\Component\HttpFoundation\Response) {
      return false;
    }

    $contentType = strtolower(
      strtok($response->headers->get('Content-Type', ''), ';')
    );

    if ($contentType === 'text/html') {
      return true;
    }

    $content = $response->getContent();

    return is_string($content)
        && (
          str_contains($content, '<html')
          || str_contains($content, '</html')
            || str_contains($content, '<!DOCTYPE html')
        );
  }

  /**
   * @param Request $request
   * @return bool
   */
  protected function isIgnoredRoute($request): bool
  {
    return $request->route() && in_array($request->route()->getName(), config('rzlzone-blade-minify.ignore_route_name', []));
  }
}

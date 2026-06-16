<?php

namespace RzlZone\BladeMinify\Middleware;

use Closure;
use RzlZone\BladeMinify\RzlBladeMinify;

class RzlBladeOutputMinifier
{
  /**
   * @param \Illuminate\Http\Request $request
   * @param Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next): mixed
  {
    /** @var \Illuminate\Http\Response */
    $response = $next($request);

    if (
      $this->isResponseObject($response)
      && $this->isResponseHtml($response)
      && ! $this->isRouteIgnored($request)
    ) {
      $html = str($response->getContent())->toString();

      $content = null;

      // Contextually process the HTML payload using a single-line conditional expression
      $shouldDisable = !config('rzlzone-blade-minify.enable', true) || (config('rzlzone-blade-minify.run_production_only', false) && !app()->isProduction());

      $content = $shouldDisable
        ? RzlBladeMinify::disableMinify($html)
        : RzlBladeMinify::minify($html);

      $response->setContent($content);
    }

    return $response;
  }

  /**
   * @param mixed $response
   * @return bool
   */
  private function isResponseObject($response): bool
  {
    return is_object($response) && $response instanceof \Symfony\Component\HttpFoundation\Response;
  }

  /**
   * @param mixed $response
   * @return bool
   */
  private function isResponseHtml($response): bool
  {
    if (! $response instanceof \Symfony\Component\HttpFoundation\Response) {
      return false;
    }

    $contentType = strtolower(
      trim(explode(
        ';',
        $response->headers->get('Content-Type', '')
      )[0])
    );

    if ($contentType === 'text/html') {
      return true;
    }

    $content = ltrim((string) $response->getContent());

    return preg_match(
      '/<html\b.*?>.*<body\b.*?>.*<\/body>.*<\/html>/is',
      $content
    ) === 1;
  }

  /**
   * @param mixed $request
   * @return bool
   */
  private function isRouteIgnored($request): bool
  {
    if (! $request instanceof \Illuminate\Http\Request) {
      return false;
    }

    return $request->route() && in_array($request->route()->getName(), config('rzlzone-blade-minify.ignore_route_name', []));
  }
}

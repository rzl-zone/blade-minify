<?php

namespace RzlZone\BladeMinify\VendorRewrites\Laravel\Boost;

use Closure;
use Illuminate\Http\Request;
use Laravel\Boost\Middleware\InjectBoost;
use Symfony\Component\HttpFoundation\Response;

class InjectBoostMiddleware extends InjectBoost
{
  /**
   * Handle an incoming request.
   *
   * @param  Closure(Request): (Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    return parent::handle($request, $next);
  }

  protected function injectScript(string $content): string
  {
    $script = \RzlZone\BladeMinify\VendorRewrites\Laravel\Boost\BrowserLogger::getScript();

    // Try to inject before closing </head>
    if (str_contains($content, '</head>')) {
      return str_replace('</head>', $script . "</head>", $content);
    }

    // Fallback: inject before closing </body>
    if (str_contains($content, '</body>')) {
      return str_replace('</body>', $script . "</body>", $content);
    }

    return $content . $script;
  }
}

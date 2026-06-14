<?php

namespace RzlZone\BladeMinify\BladeCompiler;

use Illuminate\View\Compilers\BladeCompiler;

class IgnoreMinifyBladeCompiler extends BladeCompiler
{
  protected $openExcludeMinifyCount = 0;
  public const IGNORE_START = '<!--STARTED_IGNORE_RZLZONE_BLADE_MINIFY-->';
  public const IGNORE_END   = '<!--ENDED_IGNORE_RZLZONE_BLADE_MINIFY-->';

  public function compileString($value)
  {
    $result = parent::compileString($value);

    if ($this->openExcludeMinifyCount > 0) {
      throw new \Exception('Unclosed @ignoreRzlzoneMinify directive detected.');
    }

    return $result;
  }

  public function compileExcludeMinify($expression): string
  {
    $this->openExcludeMinifyCount++;

    return "<?php echo '" . self::IGNORE_START . "'; ?>";
  }

  public function compileEndExcludeMinify($expression): string
  {
    if ($this->openExcludeMinifyCount == 0) {
      throw new \Exception('Unexpected @endIgnoreRzlzoneMinify directive detected.');
    }

    $this->openExcludeMinifyCount--;

    return "<?php echo '" . self::IGNORE_END . "'; ?>";
  }
}

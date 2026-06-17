<?php

namespace RzlZone\BladeMinify\BladeCompiler;

use Illuminate\View\Compilers\BladeCompiler;

class IgnoreMinifyBladeCompiler extends BladeCompiler
{
  protected $openExcludeMinifyCount = 0;
  final public const IGNORE_START = '<!--START_IGNORE_RZLZONE_BLADE_MINIFY-->';
  final public const IGNORE_END   = '<!--END_IGNORE_RZLZONE_BLADE_MINIFY-->';

  public function compileString($value)
  {
    $result = parent::compileString($value);

    if ($this->openExcludeMinifyCount > 0) {
      throw new \Exception('Unclosed @ignoreRzlzoneMinify directive detected.');
    }

    return $result;
  }

  public function compileExcludeMinify($expression)
  {
    $this->openExcludeMinifyCount++;

    return "<?php echo '" . self::IGNORE_START . "'; ?>";
  }

  public function compileEndExcludeMinify($expression)
  {
    if ($this->openExcludeMinifyCount == 0) {
      throw new \Exception('Unexpected @endIgnoreRzlzoneMinify directive detected.');
    }

    $this->openExcludeMinifyCount--;

    return "<?php echo '" . self::IGNORE_END . "'; ?>";
  }
}

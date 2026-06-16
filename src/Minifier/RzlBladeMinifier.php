<?php

namespace RzlZone\BladeMinify\Minifier;

use RzlZone\BladeMinify\BladeCompiler\IgnoreMinifyBladeCompiler;

class RzlBladeMinifier
{
  /** Core minification engine for HTML, Inline JavaScript, and Inline CSS.
   *
   * Isolates specific structural tags (scripts, styles, pre, textareas) and
   * Blade-ignored blocks before performing global whitespace and comment removal.
   *
   * @param string|null $html The raw HTML document layout to be minified.
   * @return string The contextually compressed HTML output.
   */
  public function minify($html = null): string
  {
    // Early exit if the input is null, empty, or whitespace-only
    if (!__rzl_bm_is_non_empty_string__($html)) {
      return "";
    }

    $blocks = [];

    // 1. Isolate and protect Blade ignore blocks FIRST to prevent internal parsing
    preg_match_all(
      '/'
        . preg_quote(IgnoreMinifyBladeCompiler::IGNORE_START, '/')
        . '(.*?)'
        . preg_quote(IgnoreMinifyBladeCompiler::IGNORE_END, '/')
        . '/s',
      $html,
      $matches
    );

    foreach ($matches[0] as $index => $exclude) {
      $token = "%%%EXCL_{$index}%%%";

      $blocks[$token] = $exclude;

      $html = str_replace($exclude, $token, $html);
    }

    // 2. Isolate and safely handle contents inside sensitive structural tags
    $html = preg_replace_callback(
      '#<(script|style|pre|textarea)\b([^>]*)>(.*?)</\1>#is',
      function ($matches) use (&$blocks) {
        $tag = strtolower($matches[1]);
        $attributes = $matches[2];
        $content = $matches[3];

        $token = '%%%BLOCK_' . count($blocks) . '%%%';

        // Process script blocks explicitly depending on their content specifications
        if ($tag === 'script' && __rzl_bm_is_non_empty_string__($content)) {
          // Initialize default fallback type as native javascript
          $scriptType = 'text/javascript';

          // Extract explicit MIME type attribute if available
          if (str_contains(strtolower($attributes), 'type')) {
            preg_match('/type=[\x22\x27]([^\x22\x27]+)[\x22\x27]/i', $attributes, $typeMatch);
            $scriptType = isset($typeMatch[1]) ? strtolower(trim($typeMatch[1])) : '';
          }

          try {
            // Evaluate whether the script is standard JavaScript or data text/template wrappers
            if ($scriptType !== '' && !in_array($scriptType, ['text/javascript', 'module', 'application/javascript'])) {
              // Minify safely as structural JSON configurations or plain template string data
              $content = $this->handleNonStandardScript($scriptType, $content);
            } else {
              // Apply standard JS optimization pipeline including semicolon injection
              $content = $this->minifyInlineJs($this->insertJsSemicolon($content));
            }
          } catch (\Throwable $e) {
          }
        }

        // Apply standard inline CSS property minification pipeline
        if ($tag === 'style' && __rzl_bm_is_non_empty_string__($content)) {
          try {
            $content = $this->minifyInlineCss($this->insertCssSemicolon($content));
          } catch (\Throwable $e) {
          }
        }

        $blocks[$token] = "<{$matches[1]}{$matches[2]}>" . $content . "</{$matches[1]}>";

        return $token;
      },
      $html
    );

    // 3. Apply minification policies for global raw HTML tokens only
    $replace = [
      // Convert standalone line breaks to a single space token
      '/\n/'                       => " ",

      // Strip document-level structural HTML comments
      '/\<\!--.*?-->/'             => "",

      // Collapse consecutive space sequences and redundant tabs into a single white space
      '/[ \t]+/' => ' ',

      // Trim internal whitespace barriers between adjacent structural HTML element tags (handles >, />, \>, and \/>)
      // Example: </div>    <span> -> </div><span>
      '/\\\\?\/?>(\s++)?(.*?)(\s++)?\\\\?\/?</s' => ">$2<",
      // '/\>(\s++)?(.*?)(\s++)?</s' => ">$2<",
    ];

    $html = preg_replace(
      array_keys($replace),
      array_values($replace),
      $html
    );

    // 4. Restore ALL isolated structural placeholders back to their absolute positions
    foreach ($blocks as $token => $content) {
      $html = str_replace($token, $content, $html);
    }

    return $this->finalizeHtmlCompression($html);
  }

  /** Wrap raw HTML tokens inside a protected Blade Minify boundary.
   *
   * Prevents any compressor execution from executing inside the wrapped content.
   *
   * @param string|null $html The targeted HTML string to protect.
   * @return string The protected block wrapped inside literal directive markers.
   */
  public function ignoreMinify($html = null): string
  {
    // Convert null or whitespace-only inputs into a clean empty string
    if (!__rzl_bm_is_non_empty_string__($html)) {
      $html = "";
    }

    return IgnoreMinifyBladeCompiler::IGNORE_START . (string) $html . IgnoreMinifyBladeCompiler::IGNORE_END;
  }

  /** Strip raw directive compiler isolation markers from the layout string payload.
   *
   * @param string|null $html The HTML layout context containing isolation boundaries.
   * @return string The raw context string stripped of directive isolation tags.
   */
  public function disableMinify($html = null): string
  {
    // Early exit if the input is null, empty, or whitespace-only
    if (!__rzl_bm_is_non_empty_string__($html)) {
      return "";
    }

    return str_replace(
      [IgnoreMinifyBladeCompiler::IGNORE_START, IgnoreMinifyBladeCompiler::IGNORE_END],
      '',
      $html
    );
  }

  /** Perform final post-processing and cleanup on the minified HTML payload.
   *
   * Strips remaining Blade ignore directive markers along with their surrounding
   * whitespaces, collapses gaps between layout elements, and tightens tag definitions.
   *
   * @param string $input The processed HTML layout context containing temporary placeholders.
   * @return string The finalized, tightly packed HTML output.
   */
  private function finalizeHtmlCompression($input)
  {
    $start = IgnoreMinifyBladeCompiler::IGNORE_START;
    $end = IgnoreMinifyBladeCompiler::IGNORE_END;

    $replace = [
      // Pattern 1: Remove whitespace surrounding IGNORE_START and IGNORE_END markers (handles > and />)
      "/\\\\?\\/?\\>(\\s++)?(?:$start|$end)(\\s++)?</s" => '><',

      // Pattern 2: Remove whitespace before sensitive asset blocks (handles > and />)
      '/(\\/?\\>)\\s+(?=<(?:script|style|pre|textarea)\\b)/i' => '$1',

      // Pattern 3: Strip trailing whitespace inside normal tags safely (e.g., <div class="x" > to <div class="x">)
      '/\\s+(?=\\>)/' => '',

      // Pattern 4: Strip trailing whitespace inside self-closing tags safely (e.g., <img src="x"  /> to <img src="x" />)
      '/\\s+(?=\\/\\>)/' => '',
    ];

    return preg_replace(
      array_keys($replace),
      array_values($replace),
      $input
    );
  }

  /** Inject missing semicolons to CSS declarations and clean up structural anomalies.
   *
   * Ensures every standard CSS property ends with a semicolon before minification.
   *
   * @param string $value The raw CSS content to be processed.
   * @return string The processed CSS content with appropriate semicolons.
   */
  private function insertCssSemicolon($value)
  {
    return preg_replace([
      // Pattern 1: Append missing semicolon to single-line CSS declarations
      '#^[A-Za-z\s\-]+:.+(?<!({|}|;))$#m',
      // Pattern 2: Remove accidental semicolons immediately before a CSS block opens
      '#^([A-Za-z\s\-]+):(.+)[;]$(\n+|\s+){#m',
    ], [
      '$0;',
      '$1:$2$3{',
    ], $value);
  }

  /** Automatically inject missing semicolons into JavaScript statements.
   *
   * Parses the code line-by-line, stripping comments, handling template literals,
   * and evaluating structural contexts to determine if a semicolon is required.
   *
   * @param string $value The raw JavaScript content to be processed.
   * @return string The JavaScript content with structural semicolons injected.
   */
  private function insertJsSemicolon($value)
  {
    $result = [];

    // 1. Strip multi-line and single-line comments from the JavaScript source
    $value = preg_replace('/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/', '', $value);

    // 2. Temporarily strip newlines within template literals (backticks) to prevent misparsing
    $value = preg_replace_callback('/(`[\S\s]*?[^\\\`]`)/', function ($m) {
      return preg_replace('/\n+/', '', $m[1]);
    }, $value);

    $code = explode("\n", trim($value));

    // Define regex patterns that exclude a line from receiving a semicolon at the end
    $patternRegex = [
      // Trailing structural characters
      '#(?:({|\[|\(|,|;|=>|\:|\?|\.))$#',
      // Empty lines
      '#^\s*$#',
      // Keyword structures that continue on the next line
      '#^(do|else)$#',
    ];

    $loop = 0;

    foreach ($code as $line) {
      $loop++;
      $insert = false;
      $shouldInsert = true;

      // Validate the current line against exclusion patterns
      foreach ($patternRegex as $pattern) {
        $match = preg_match($pattern, trim($line));
        $shouldInsert = $shouldInsert && (bool) !$match;
      }

      if ($shouldInsert) {
        $i = $loop;

        // Look ahead to the next non-empty line to determine context
        while (true) {
          if ($i >= count($code)) {
            $insert = true;
            break;
          }

          $c = trim($code[$i]);
          $i++;

          if (!$c) {
            continue;
          }

          $insert = true;
          $regex = ['#^(\?|\:|,|\.|{|}|\)|\])#'];

          // Skip semicolon if the next line starts with a continuing operator or bracket
          foreach ($regex as $r) {
            $insert = $insert && (bool) !preg_match($r, $c);
          }

          // Special case: Prevent semicolon between a closing brace and control structures (else/catch)
          if ($insert) {
            if (preg_match('#(?:\\})$#', trim($line)) && preg_match("#^(else|elseif|else\s*if|catch)#", $c)) {
              $insert = false;
            }
          }

          break;
        }
      }

      // Append semicolon if all validation checks pass
      if ($insert) {
        $result[] = sprintf('%s;', $line);
      } else {
        $result[] = $line;
      }
    }

    return join("\n", $result);
  }

  /** Process and minify non-standard scripts (JSON, templates, plain text).
   *
   * Contextually compresses the payload depending on whether it is structural
   * data (JSON/Importmaps) or loose text/HTML templates.
   *
   * @param string $type The explicit MIME content-type attribute of the script tag.
   * @param string $content The raw inner content of the script tag.
   * @return string The contextually minified content.
   */
  private function handleNonStandardScript(string $type, string $content): string
  {
    if (!__rzl_bm_is_non_empty_string__($content)) {
      return '';
    }

    // Minify JSON structures safely or collapse redundant whitespaces for text/HTML templates
    return (str_contains($type, 'json') || $type === 'importmap')
      ? preg_replace('#\s*([\{\}\[\]\:,])\s*#s', '$1', $content)
      : preg_replace('#\s+#s', ' ', $content);
  }

  /** Minify inline JavaScript content using regex patterns.
   *
   * Strips whitespaces, inline comments, cleans up object attributes,
   * and converts boolean values to short expressions (!0/!1).
   *
   * @param string $value The raw JavaScript content to be minified.
   * @return string The minified JavaScript content.
   */
  private function minifyInlineJs($value)
  {
    // 1. Execute general JavaScript minification patterns
    $value = trim(preg_replace([
      // Remove horizontal whitespaces, blocks, and single-line comments
      '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
      // Remove whitespaces outside strings, block comments, and regex literals
      '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
      // Remove trailing semicolons and commas before closing curly braces
      '#[;,\s]+\}#',
      // Minify object attributes except JSON attributes (e.g., {'foo':'bar'} to {foo:'bar'})
      '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
      // Minify square bracket notation for object attributes into dot notation (e.g., foo['bar'] to foo.bar)
      '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i',
    ], [
      '$1',
      '$1$2',
      '}',
      '$1$3',
      '$1.$3',
    ], $value));

    // 2. Safely convert true to !0 and false to !1 using callback to protect strings
    $value = preg_replace_callback(
      '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\b(true|false)\b#i',
      function ($matches) {
        // Return original string untouched if it matches inside quotes (Group 1)
        if (!empty($matches[1])) {
          return $matches[1];
        }

        // Convert strict standalone booleans (Group 2)
        if (strtolower($matches[2]) === 'true') {
          return '!0';
        }
        if (strtolower($matches[2]) === 'false') {
          return '!1';
        }

        return $matches[0];
      },
      $value
    );

    return $value;
  }

  /** Minify inline CSS content using advanced regex patterns.
   *
   * Compresses properties, eliminates unused whitespaces, optimizes color codes,
   * strips units from zero values, and removes redundant structures.
   *
   * @param string $value The raw CSS content to be minified.
   * @param bool $allowInsertSemicolon Optional flag to toggle structural enhancements.
   * @return string The highly compressed CSS content.
   */
  private function minifyInlineCss(string $value, bool $allowInsertSemicolon = true): string
  {
    return trim(preg_replace([
      // Pattern 1: Strip standard CSS block comments
      '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',

      // Pattern 2: Strip non-essential whitespaces around punctuation, braces, and operators
      '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',

      // Pattern 3: Strip units from zero values (e.g., '0px', '0em' to '0')
      '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',

      // Pattern 4: Collapse redundant zero sequences in shorthand properties (e.g., ':0 0 0 0' to ':0')
      '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',

      // Pattern 5: Fix zero shorthand specification specific to background-position
      '#(background-position):0(?=[;\}])#si',

      // Pattern 6: Strip leading zeros from floating-point decimals (e.g., '0.6' to '.6')
      '#(?<=[\s:,\-])0+\.(\d+)#s',

      // Pattern 7: Clean up unneeded quotes inside generic string values
      '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',

      // Pattern 8: Strip quotes from URL wrappers where valid (e.g., 'url("foo.png")' to 'url(foo.png)')
      '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',

      // Pattern 9: Compress repeating HEX color values (e.g., '#ffffff' to '#fff', '#aabbcc' to '#abc')
      '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',

      // Pattern 10: Optimize 'none' shorthand property expressions into zeros (e.g., 'border:none' to 'border:0')
      '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',

      // Pattern 11: Remove empty rule blocks and redundant selectors (e.g., 'div{}' to '')
      '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s',
    ], [
      '$1',
      '$1$2$3$4$5$6$7',
      '$1',
      ':0',
      '$1:0 0',
      '.$1',
      '$1$3',
      '$1$2$4$5',
      '$1$2$3',
      '$1:0',
      '$1$2',
    ], $value));
  }
}

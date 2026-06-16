<?php

/** * Get File Path. */
if (!function_exists(function: "__rzl_bm_get_path_file__")) {
  /** * Get normalized file path.
   *
   * Replaces backslashes with forward slashes, removes duplicate slashes,
   * optionally removes first leading slash, and optionally converts all
   * separators into backslashes.
   *
   * If `$fileOrPathName` is empty, default value will be used when provided.
   *
   * @param string|null $fileOrPathName File path value.
   * @param bool $removeFirstSlash Remove first leading slash.
   * @param bool $useBackSlash Convert separators to backslashes.
   * @param string|null $default Default path when `$fileOrPathName` is empty.
   * @return string|null Normalized file path or null.
   */
  function __rzl_bm_get_path_file__($fileOrPathName, $removeFirstSlash = true, $useBackSlash = false, $default = null): string|null
  {
    // 1. Handle empty input by falling back to the default value
    if (blank($fileOrPathName)) {
      return blank($default) ? null : __rzl_bm_get_path_file__($default, $removeFirstSlash, $useBackSlash);
    }

    // 2. Normalize slashes (convert backslashes to forward slashes & remove duplicates)
    $path = str($fileOrPathName)->replace('\\', '/')->replaceMatches('#/{2,}#', '/');

    // 3. Strip the leading slash if requested
    if ($removeFirstSlash && $path->startsWith('/')) {
      $path = $path->after('/');
    }

    // 4. Convert to backslashes if requested, then return as a string
    return $useBackSlash ? $path->replace('/', '\\')->toString() : $path->toString();
  }
}

if (!function_exists("__rzl_bm_is_non_empty_string__")) {
  /**
    * Determine whether the given value is a non-empty string.
    *
    * Returns true only if the value is a string and contains
    * at least one character.
    *
    * When `$trim` is enabled (**default: true**), leading
    * and trailing whitespace are removed before checking.
    *
    * @param mixed $value The value to evaluate.
    * @param bool $trim Whether to trim whitespace before checking.
    * @return bool `true` if the value is a non-empty string; otherwise, false.
    */
  function __rzl_bm_is_non_empty_string__($value, $trim = true): bool
  {
    if (!is_string($value)) {
      return false;
    }

    $val = str($value);

    if ($trim) {
      $val = $val->trim();
    }

    return $val->isNotEmpty();
  }
}

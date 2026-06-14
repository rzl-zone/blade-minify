<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return (new Config())
  ->setRiskyAllowed(isRiskyAllowed: false)
  ->setIndent(indent: '  ')
  ->setRules(rules: [
    '@PSR12' => true,
    'array_indentation' => true,
    'indentation_type' => true,
    'no_extra_blank_lines' => [
      'tokens' => [
        'extra',
        'throw',
        'use',
        'return',
        'continue',
        'break',
        'curly_brace_block',
        'parenthesis_brace_block',
        'square_brace_block',
      ],
    ],
    'single_blank_line_at_eof' => true,
  ])
  // by default, Fixer looks for `*.php` files excluding `./vendor/` - here, you can groom this config
  ->setFinder(
    finder: (new Finder())
      // root folder to check
      ->in(dirs: __DIR__)
      ->name(patterns: '*.php')
      ->notName(patterns: '*.blade.php')
      ->exclude(dirs: 'vendor')
    // additional files, eg bin entry file
    // ->append([__DIR__.'/bin-entry-file'])
    // folders to exclude, if any
    // ->exclude([/* ... */])
    // path patterns to exclude, if any
    // ->notPath([/* ... */])
    // extra configs
    // ->ignoreDotFiles(false) // true by default in v3, false in v4 or future mode
    // ->ignoreVCS(true) // true by default
  )
;

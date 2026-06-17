<?php

namespace RzlZone\BladeMinify\VendorRewrites\Laravel\Vite;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use RzlZone\BladeMinify\Support\RzlBladeInternalAttribute;

class CustomVite extends \Illuminate\Foundation\Vite
{
  private $isUseAsyncOrDefer = false;

  private $persistenceRzlAttr = [];

  private $preferredData = [];

  protected $__AttrMainKey = RzlBladeInternalAttribute::INTERNAL_ATTRIBUTE_KEY;
  protected $__AttrKeyIgnoreMinify = RzlBladeInternalAttribute::INTERNAL_ATTRIBUTE_KEY_IGNORE;

  /** ------------------------------------------------------------------
   * * ***Generate Vite tags for an entrypoint view layout.***
   * ------------------------------------------------------------------
   *
   * This magic invoker serves as the primary entrypoint compilation bridge. It merges
   * localized tag persistence attributes before proxying the payload execution stack
   * directly back into the core parent framework compiler runtime lifecycle.
   *
   * - Explicit Behavior Lifecycle:
   *    1. Constructs the dynamic localized layout persistence state array buffer.
   *    2. Conditionally unpacks asynchronous or deferred structural modifiers using high-performance
   *       state evaluation boundaries if `isUseAsyncOrDefer` is enabled.
   *    3. Delegates asset generation downstream to the framework's ancestral core invoker sequence.
   *
   * @param string|string[] $entrypoints The explicit file path or collection array of targeted entry assets.
   * @param string|null $buildDirectory Custom build directory override path context segment if applicable.
   * @throws \Exception Thrown dynamically if core path compilation or manifest data reading fails downstream.
   * @return \Illuminate\Support\HtmlString The fully compiled, raw HTML string container containing asset asset bindings.
   */
  public function __invoke($entrypoints, $buildDirectory = null)
  {
    $this->persistenceRzlAttr = [
      $this->__AttrMainKey => true,
      ...($this->isUseAsyncOrDefer === true ? $this->preferredData : [])
    ];

    return parent::__invoke($entrypoints, $buildDirectory);
  }

  /** ------------------------------------------------------------------
   * * ***Set the dynamic runtime Vite hot reloading token file path.***
   * ------------------------------------------------------------------
   *
   * Registers the explicit file location where the hot reload communication manifest
   * server URL payload resides, allowing seamless local development stream switching.
   *
   * - Explicit Behavior Lifecycle:
   *    1. Evaluates the incoming custom `$path` string token via internal non-empty validators.
   *    2. If valid, binds the core file target location directly to the user-supplied state.
   *    3. If blank or omitted, attempts fallback acquisition from the application configuration store (`rzlzone-blade-minify.custom-vite.hot_file`).
   *    4. Caches the runtime state location context and returns the local chain instance safely.
   *
   * @param string|null $path Optional absolute file location override path target.
   * @return $this The fluid configuration class instance object container.
   */
  public function useHotFile($path = null)
  {
    if (__rzl_bm_is_non_empty_string__($path)) {
      $this->hotFile = $path;
    } elseif (__rzl_bm_is_non_empty_string__(config('rzlzone-blade-minify.custom-vite.hot_file'))) {
      $this->hotFile = config('rzlzone-blade-minify.custom-vite.hot_file');
    }

    return $this;
  }

  /** ------------------------------------------------------------------
   * * ***Set the compiled structural production asset build directory.***
   * ------------------------------------------------------------------
   *
   * Specifies the primary filesystem sub-directory structure inside the public web root
   * where the finalized production build assets and layout files are queried.
   *
   * - Explicit Behavior Lifecycle:
   *    1. Evaluates incoming custom directory `$path` segments for structural validation compliance.
   *    2. Commits explicit folder name arguments straight onto the active property buffer if non-empty.
   *    3. Automatically resolves back to core framework defaults (`rzlzone-blade-minify.custom-vite.build_dir`) if inputs are missing.
   *    4. Returns the fluent parent modifier context sequence to enable subsequent call chaining.
   *
   * @param string|null $path Optional target folder asset path segment override string name.
   * @return $this The fluid configuration class instance object container.
   */
  public function useBuildDirectory($path = null)
  {
    if (__rzl_bm_is_non_empty_string__($path)) {
      $this->buildDirectory = $path;
    } elseif (__rzl_bm_is_non_empty_string__(config('rzlzone-blade-minify.custom-vite.build_dir'))) {
      $this->buildDirectory = config('rzlzone-blade-minify.custom-vite.build_dir');
    }

    return $this;
  }

  /** ------------------------------------------------------------------
    * * ***Set the structural tracking filename for the JSON manifest file.***
    * ------------------------------------------------------------------
    *
    * Customizes the explicit compilation mapping manifest filename key used to bind
    * compiled production assets back into raw server-side view injections.
    *
    * - Explicit Behavior Lifecycle:
    *    1. Gauges raw `$filename` parameters to filter out blank whitespace or non-string inputs.
    *    2. Commits explicit name definitions directly onto the target property location buffer if validated.
    *    3. Defaults back onto framework manifest name config keys (`rzlzone-blade-minify.custom-vite.manifest_name`) as a safe fallback trace.
    *    4. Returns the active operational class instance layout context state.
    *
    * @param string|null $filename Optional custom naming scheme descriptor string override (e.g., "manifest.json").
    * @return $this The fluid configuration class instance object container.
    */
  public function useManifestFilename($filename = null)
  {
    if (__rzl_bm_is_non_empty_string__($filename)) {
      $this->manifestFilename = $filename;
    } elseif (__rzl_bm_is_non_empty_string__(config('rzlzone-blade-minify.custom-vite.manifest_name'))) {
      $this->manifestFilename = config('rzlzone-blade-minify.custom-vite.manifest_name');
    }

    return $this;
  }

  /** ------------------------------------------------------------------
     * * ***Set or contextually generate a Content Security Policy (CSP) nonce token.***
     * ------------------------------------------------------------------
     *
     * Registers a pre-defined layout encryption token or triggers automated generation
     * cycles to safeguard script execution behaviors against cross-site scripting vulnerabilities.
     *
     * - Explicit Behavior Lifecycle:
     *    1. Evaluates user-supplied custom `$nonce` token parameters via structural string helpers.
     *    2. If a non-empty string is provided, registers it directly to the local state and returns early.
     *    3. If empty, checks core framework allowance settings via `config('rzlzone-blade-minify.custom-vite.use_nonce')`.
     *    4. If enabled, compiles a high-entropy cryptographically secure random token string length of `40`.
     *    5. Returns the updated state array token layout string buffer, or null if execution parameters fail.
     *
     * @param string|null $nonce An optional pre-defined CSP nonce string.
     * @return string|null The registered or newly generated CSP nonce token.
     */
  public function useCspNonce($nonce = null)
  {
    // 1. If a valid custom nonce is provided, register and return it immediately
    if (__rzl_bm_is_non_empty_string__($nonce)) {
      return $this->nonce = $nonce;
    }

    // 2. Generate a random fallback token only if the explicit configuration criteria are met
    if (config('rzlzone-blade-minify.custom-vite.use_nonce', false)) {
      return $this->nonce = Str::random(40);
    }

    // 3. Return the current state if no new values or generation rules match
    return $this->nonce;
  }

  /** ------------------------------------------------------------------
   * * ***Configure the default asynchronous or deferred execution strategy.***
   * ------------------------------------------------------------------
   *
   * This method registers a global compilation modifier that forces all subsequently
   * generated script tags to implicitly inherit either an `async` or `defer` attribute.
   * It implements strict parameter normalization to safely map varied inputs down
   * to a predictable structural array layout state.
   *
   * - Explicit Behavior Lifecycle:
   *    1. Sets the internal operational state flag `isUseAsyncOrDefer` to `true`.
   *    2. Sanitizes the raw `$preferredParams` input string by stripping whitespace
   *       and forcing lowercase normalization.
   *    3. Evaluates the string token. If it strictly matches `"defer"`, allocates a
   *       `['defer' => true]` layout definition array buffer.
   *    4. If the token strictly matches `"async"`, allocates an `['async' => true]`
   *       layout definition array buffer.
   *    5. If the input is blank, `false`, `null`, `"unset"`, or an unmapped invalid string token,
   *       implicitly falls back, flushes the buffer to an empty array `[]`, and skips assignment.
   *    6. Returns the current class instance object to facilitate seamless method chaining.
   *
   * @param string|bool|null $preferredParams The desired execution mode (`"async"`, `"defer"`, `"unset"`, or `false`).
   * @return $this The fluid configuration class instance object container.
   */
  public function useAsyncOrDeferDefault($preferredParams = "unset")
  {
    $this->isUseAsyncOrDefer = true;

    $preferred = str($preferredParams)->trim()->lower();

    if (filled($preferred->toString()) && $preferred->is("defer")) {
      $this->preferredData = ["defer" => true];

      return $this;
    }

    if (filled($preferred->toString()) && $preferred->is("async")) {
      $this->preferredData = ["async" => true];

      return $this;
    }

    $this->preferredData = [];

    return $this;
  }

  /** ------------------------------------------------------------------
   * * ***Make tag for the given chunk.***
   * -------------------------------------------------------------------
   *
   * @param  string  $src
   * @param  string  $url
   * @param  array|null  $chunk
   * @param  array|null  $manifest
   * @return string
   */
  protected function makeTagForChunk($src, $url, $chunk, $manifest)
  {
    if (
      $this->nonce === null
      && $this->integrityKey !== false
      && !array_key_exists($this->integrityKey, $chunk ?? [])
      && $this->scriptTagAttributesResolvers === []
      && $this->styleTagAttributesResolvers === []
    ) {
      if ($this->isCssPath($url)) {
        return $this->makeStylesheetTagWithAttributes($url, []);
      }

      return $this->makeScriptTagWithAttributes($url, []);
    }

    if ($this->isCssPath($url)) {
      $attrCss = $this->resolveStylesheetTagAttributes($src, $url, $chunk, $manifest);

      return $this->makeStylesheetTagWithAttributes(
        $url,
        array_merge(
          Arr::except($attrCss, [$this->__AttrMainKey]),
          [
            $this->__AttrMainKey => true,
          ]
        )
      );
    }

    $attrScript = $this->resolveScriptTagAttributes($src, $url, $chunk, $manifest);

    return $this->makeScriptTagWithAttributes(
      $url,
      array_merge(
        Arr::except($attrScript, [$this->__AttrMainKey]),
        [
          $this->__AttrMainKey => true,
        ]
      )
    );
  }

  /** ------------------------------------------------------------------
   * * ***Resolve the attributes for the chunks generated preload tag.***
   * -------------------------------------------------------------------
   *
   * @param  string  $src
   * @param  string  $url
   * @param  array  $chunk
   * @param  array  $manifest
   * @return array|false
   */
  protected function resolvePreloadTagAttributes($src, $url, $chunk, $manifest)
  {
    $attributes = $this->isCssPath($url) ? array_merge(
      [
        'rel' => 'preload',
        'as' => 'style',
        'href' => $url,
        'nonce' => $this->nonce ?? false,
        'crossorigin' => $this->resolveStylesheetTagAttributes($src, $url, $chunk, $manifest)['crossorigin'] ?? false,
      ],
    ) : array_merge(
      [
        'rel' => 'modulepreload',
        'href' => $url,
        'nonce' => $this->nonce ?? false,
        'crossorigin' => $this->resolveScriptTagAttributes($src, $url, $chunk, $manifest)['crossorigin'] ?? false,
      ],
    );

    $attributes = $this->integrityKey !== false
      ? array_merge($attributes, ['integrity' => $chunk[$this->integrityKey] ?? false])
      : $attributes;

    /** @var callable(string, string, array, array): array $resolver */
    foreach ($this->preloadTagAttributesResolvers as $resolver) {
      if (false === ($resolvedAttributes = $resolver($src, $url, $chunk, $manifest))) {
        return false;
      }

      $attributes =  array_merge(
        $attributes,
        self::resolvePersistenceRzlAtr($resolvedAttributes),
        Arr::except($resolvedAttributes, [
          "integrity",
          "rel",
          "as",
          "href",
          "nonce",
          "crossorigin",
          "async",
          "defer",
          $this->__AttrMainKey,
        ])
      );
    }

    return (new Collection($this->preloadTagAttributesResolvers))->isEmpty() ?
      array_merge(
        Arr::except($attributes, [
          "async",
          "defer",
        ]),
        self::resolvePersistenceRzlAtr($attributes),
      ) :
      $attributes;
  }

  /** ------------------------------------------------------------------
   * * ***Resolve the attributes for the chunks generated script tag.***
   * -------------------------------------------------------------------
   *
   * @param  string  $src
   * @param  string  $url
   * @param  array|null  $chunk
   * @param  array|null  $manifest
   * @return array
   */
  protected function resolveScriptTagAttributes($src, $url, $chunk, $manifest)
  {
    $attributes = $this->integrityKey !== false
      ? ['integrity' => $chunk[$this->integrityKey] ?? false]
      : [];

    /** @var callable(string, string, array, array): array $resolver */
    foreach ($this->scriptTagAttributesResolvers as $resolver) {
      $attributes = array_merge(
        $attributes,
        Arr::except($resolver($src, $url, $chunk, $manifest), ["integrity"])
      );
    }

    return $attributes;
  }

  /** ------------------------------------------------------------------
   * * ***Resolve the attributes for the chunks generated stylesheet tag.***
   * -------------------------------------------------------------------
   *
   * @param  string  $src
   * @param  string  $url
   * @param  array|null  $chunk
   * @param  array|null  $manifest
   * @return array
   */
  protected function resolveStylesheetTagAttributes($src, $url, $chunk, $manifest)
  {
    $attributes = $this->integrityKey !== false
      ? ['integrity' => $chunk[$this->integrityKey] ?? false]
      : [];

    /** @var callable(string, string, array, array): array $resolver */
    foreach ($this->styleTagAttributesResolvers as $resolver) {
      $attributes = array_merge(
        $attributes,
        Arr::except($resolver($src, $url, $chunk, $manifest), ["integrity"])
      );
    }

    return $attributes;
  }

  /** ------------------------------------------------------------------
   * * ***Generate a link tag with attributes for the given URL.***
   * -------------------------------------------------------------------
   *
   * @param  string  $url
   * @param  array  $attributes
   * @return string
   */
  protected function makeStylesheetTagWithAttributes($url, $attributes)
  {
    $attributes = $this->parseAttributes(
      array_merge(
        [
          'rel' => 'stylesheet',
          'href' => $url,
          'nonce' => $this->nonce ?? false,
        ],
        self::resolvePersistenceRzlAtr($attributes),
        Arr::except($attributes, [
          "rel",
          "href",
          "nonce",
          $this->__AttrMainKey,
          "async",
          "defer",
        ]),
      )
    );

    return '<link ' . implode(' ', $attributes) . ' />';
  }

  /** ------------------------------------------------------------------
   * * ***Generate a script tag with attributes for the given URL.***
   * -------------------------------------------------------------------
   *
   * @param  string  $url
   * @param  array  $attributes
   * @return string
   */
  protected function makeScriptTagWithAttributes($url, $attributes)
  {
    $attributes = $this->parseAttributes(
      array_merge(
        [
          'type' => 'module',
          'src' => $url,
          'nonce' => $this->nonce ?? false,
        ],
        self::resolvePersistenceRzlAtr($attributes),
        Arr::except($attributes, [
          "type",
          "src",
          "nonce",
          $this->__AttrMainKey,
          "async",
          "defer",
        ]),
      )
    );

    return '<script ' . implode(' ', $attributes) . '></script>';
  }

  /** ------------------------------------------------------------------
   * * ***Generate and inject the React Refresh runtime preamble script.***
   * ------------------------------------------------------------------
   *
   * This method contextually compiles and returns the inline script payload required
   * to bootstrap React's Fast Refresh architecture during active local development cycles.
   * It ensures that stateful hot reloading functions smoothly without fully reloading the DOM.
   *
   * - Explicit Behavior Lifecycle:
   *    1. Evaluates the active infrastructure environment state via `isRunningHot()`. If the
   *       Vite dev server is offline, aborts execution early and returns void.
   *    2. Isolates and prepares critical HTML attribute keys to prevent raw, user-supplied
   *       data overrides from corrupting security headers.
   *    3. Resolves core internal states including module registration, framework asset locators
   *       (`@react-refresh`), and secure Content Security Policy (CSP) nonce tokens.
   *    4. Aggregates the computed metadata bindings into a safe, raw `HtmlString` container.
   *
   * @param array $dataAttribute Custom optional associative HTML attribute overrides provided by the layout view.
   * @return \Illuminate\Support\HtmlString|void The compiled inline script element payload container, or void if offline.
   */
  public function reactRefresh($dataAttribute = [])
  {
    if (!$this->isRunningHot()) {
      return;
    }

    $excludedKeys = ['type', 'nonce', 'async', 'defer', $this->__AttrMainKey, $this->__AttrKeyIgnoreMinify];

    $dataAttribute = is_array($dataAttribute) ? $dataAttribute : [];

    // Conditionallly inject the ignore-minify marker during local development environment cycles
    $localOverrides = app()->isLocal() ? [$this->__AttrKeyIgnoreMinify => true] : [];

    $attributes = $this->parseAttributes(array_merge(
      [
        'type' => 'module',
        $this->__AttrMainKey => true,
        'nonce' => $this->cspNonce(),
      ],
      Arr::except($dataAttribute, $excludedKeys),
      $localOverrides
    ));

    return new \Illuminate\Support\HtmlString(
      sprintf(
        <<<'HTML'
          <script %s>
            import RefreshRuntime from "%s";
            RefreshRuntime.injectIntoGlobalHook(window);
            window.$RefreshReg$ = () => {};
            window.$RefreshSig$ = () => (type) => type;
            window.__vite_plugin_react_preamble_installed__ = true;

            console.debug("`@reactRefresh` by `CustomVite` from `rzl-zone/blade-minify` is active...");
          </script>
          HTML,
        implode(' ', $attributes),
        $this->hotAsset('@react-refresh')
      )
    );
  }

  /** -------------------------------------------------------------------
   * * ***Resolve and filter persistence script attributes based on mutual exclusion rules.***
   * -------------------------------------------------------------------
   *
   * This method contextually evaluates the incoming script element attributes to enforce
   * a strict mutual exclusion standard between `async` and `defer` states. Since a script
   * cannot logically execute both concurrently, this filter establishes a priority override:
   *
   * - Explicit Behavior Lifecycle:
   *    1. If the `defer` key exists in the input payload, any existing `async` state is forcefully
   *       purged from the state buffer, and `defer` is locked to `true`.
   *    2. If the `async` key exists (and `defer` was absent), any existing `defer` state is
   *       forcefully purged, and `async` is locked to `true`.
   *    3. If neither key is present within the incoming payload, the method returns the default
   *       internal persistence state unaltered.
   *
   * @param array $attributes The raw, incoming associative array of script element attributes to evaluate.
   * @return array The filtered, single-dimension state array containing strictly clean persistence mappings.
   */
  protected function resolvePersistenceRzlAtr($attributes)
  {
    if (array_key_exists('defer', $attributes)) {
      return array_merge(Arr::except($this->persistenceRzlAttr, ['async']), ['defer' => true]);
    }

    if (array_key_exists('async', $attributes)) {
      return array_merge(Arr::except($this->persistenceRzlAttr, ['defer']), ['async' => true]);
    }

    return $this->persistenceRzlAttr;
  }

  /** ------------------------------------------------------------------
   * * ***Resolve, decode, and cache the compilation manifest array for the given build directory.***
   * ------------------------------------------------------------------
   *
   * This method acts as a strict stateful accessor for the Vite manifest JSON payload.
   * It implements an in-memory runtime cache mechanism via a static state store (`static::$manifests`)
   * to mitigate redundant, expensive disk I/O operations across the current request lifecycle.
   *
   * - Explicit Behavior Lifecycle:
   *    1. Resolves the absolute filesystem path via the internal `manifestPath` locator.
   *    2. Checks the static memory buffer. If cached, skips filesystem lookups entirely.
   *    3. Verifies filesystem existence. If the file is missing, compiles a structural diagnostics
   *       trace using `__rzl_bm_get_path_file__` and halts execution via a fatal exception.
   *    4. Parses the raw JSON stream into a native associative array and commits it to the cache store.
   *
   * @param string $buildDirectory The target asset build directory segment to evaluate.
   * @throws \Illuminate\Foundation\ViteException
   * Thrown with formatted diagnostic hints if the manifest file does not exist on disk.
   * @return array The structural associative mapping decoded directly from the Vite build manifest payload.
   */
  protected function manifest($buildDirectory)
  {
    $path = $this->manifestPath($buildDirectory);

    if (! isset(static::$manifests[$path])) {
      if (! is_file($path)) {
        throw new \Illuminate\Foundation\ViteException(
          "Unable to find Vite manifest at ["
          . __rzl_bm_get_path_file__($path, useBackSlash: true)
          . "] — ensure the Vite dev server is running (pnpm/npm run dev) or assets have been built (pnpm/npm run build:ssr)."
        );
      }

      static::$manifests[$path] = json_decode(file_get_contents($path), true);
    }

    return static::$manifests[$path];
  }

  /** ------------------------------------------------------------------
   * * ***Get Full Path Manifest File Including Manifest File Name.***
   * -------------------------------------------------------------------
   *
   * This method extracts the build directory configuration and manifest filename,
   * applying strict defensive sanitization routines to eliminate structural risks
   * such as accidental double-slashes (`//`), trailing whitespace overheads, or
   * empty config injection payloads.
   *
   * Explicit Behavior Lifecycle:
   * 1. Evaluates `rzlzone-blade-minify.custom-vite.build_dir` via helper. If valid, strips outer slashes and appends an explicit divider.
   * 2. Evaluates `rzlzone-blade-minify.custom-vite.manifest_name`. If missing or blank, implicitly falls back to `manifest.json`.
   * 3. Aggregates components into a single-slash bound absolute structural path prefix string.
   *
   * @final Contextually bound to core internal compiler mutations.
   * @return string The tightly formatted absolute manifest asset locator path (e.g., "/build/manifest.json").
   */
  public function getManifestFile()
  {
    $buildDir = config('rzlzone-blade-minify.custom-vite.build_dir');
    $manifestName = config('rzlzone-blade-minify.custom-vite.manifest_name');

    // Clean and resolve build directory path if it's a valid non-empty string
    $cleanedBuild = __rzl_bm_is_non_empty_string__($buildDir)
      ? trim((string) $buildDir, '/') . '/'
      : '';

    // Clean and resolve manifest filename if it's a valid non-empty string, fallback to default if empty
    $cleanedManifest = __rzl_bm_is_non_empty_string__($manifestName)
      ? trim((string) $manifestName, '/')
      : 'manifest.json'; // Optional: safe fallback name

    // Return the tightly formatted absolute path with clean single-slash barriers
    return '/' . $cleanedBuild . $cleanedManifest;
  }

  /** ------------------------------------------------------------------
   * * ***Get the Vite tag content as a string of HTML.***
   * -------------------------------------------------------------------
   *
   * @return string
   */
  public function toHtml()
  {
    return $this->__invoke($this->entryPoints)->toHtml();
  }
}

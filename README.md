<div align="center" style="display: flex;justify-content: center;flex-direction: column;align-items: center;gap: 0rem">
  <p align="center">
    <a target="_blank" rel="noopener noreferrer" href="https://raw.githubusercontent.com/rzl-zone/rzl-zone/main/logo-circle.png">
      <img src="https://raw.githubusercontent.com/rzl-zone/rzl-zone/main/logo-circle.png" align="middle" alt="RzlZone Logo" width="110" style="max-width: 100%;" />
    </a>
  </p>
</div>

<h1 align="center"><strong>Blade Minify</strong></h1>

<p align="center">
  <i>
    Blazing-Fast Output Minifier for <a href="https://laravel.com"><code>Laravel</code></a> Blade Views.
  </i><br/>
  <i><strong>Blade Minify</strong> automatically minifies your rendered HTML output, stripping unnecessary whitespaces and comments to ensure smaller page sizes and optimal load times.</i><br/>
  <strong><i>Built with ❤️ by <a href="https://github.com/rzl-zone" target="_blank" rel="nofollow noreferrer noopener">@rzl-zone</a>.</i></strong>
</p>

<div align="center" style="display: flex;justify-content: center;flex-direction: column;align-items: center;gap: 0rem">
  <p align="center">
    <a href="https://packagist.org/packages/rzl-zone/blade-minify" target="_blank" rel="nofollow noreferrer noopener">
      <img src="https://img.shields.io/packagist/v/rzl-zone/blade-minify.svg?logo=packagist&label=Latest%20Version%20Packagist&color=red&logoColor=white&style=flat-rounded" alt="Latest Version on Packagist" />
    </a>
    <a href="https://packagist.org/packages/rzl-zone/blade-minify" target="_blank" rel="nofollow noreferrer noopener">
      <img src="https://img.shields.io/packagist/dt/rzl-zone/blade-minify.svg?logo=packagist&label=Total%20Downloads%20Packagist&color=orange&logoColor=white&style=flat-rounded" alt="Total Downloads on Packagist" />
    </a>
    <a href="https://phpstan.org" target="_blank" rel="nofollow noreferrer noopener">
      <img src="https://img.shields.io/badge/phpstan-level%208-brightgreen?style=flat-rounded" alt="PHPStan Level" />
    </a>
    <a href="https://www.php.net" target="_blank" rel="nofollow noreferrer noopener">
      <img src="https://img.shields.io/badge/PHP-^8.1-blue?style=flat-rounded" alt="PHP Version" />
    </a>
    <a href="https://laravel.com" target="_blank" rel="nofollow noreferrer noopener">
      <img src="https://img.shields.io/badge/Laravel-^10.x%20|%20^11.x%20|%20^12.x%20|%20^13.x-red?style=flat-rounded" alt="Laravel Version" />
    </a>
    <a href="https://laravel.com" target="_blank" rel="nofollow noreferrer noopener">
      <img src="https://img.shields.io/badge/Illuminate%2Fsupport-^10.x%20|%20^11.x%20|%20^12.x|%20^13.x-blue?style=flat-rounded" alt="Illuminate Support" />
    </a>
    <a href="https://github.com/rzl-zone/blade-minify" target="_blank" rel="nofollow noreferrer noopener">
      <img src="https://img.shields.io/badge/Repo-on%20GitHub-181717?logo=github&style=flat-rounded" alt="GitHub" />
    </a>
    <a href="https://github.com/orgs/rzl-zone/repositories" target="_blank" rel="nofollow noreferrer noopener">
      <img src="https://img.shields.io/badge/Org-rzl--zone-24292e?logo=github&style=flat-rounded" alt="Repo on GitHub" />
    </a>
  </p>
</div>

---

## 📚 Table of Contents

- 🛠 [Requirements](#requirements)
- ⚙️ [Installation](#installation)
- 🚀 [Setup](#setup)
- 🔥 [Usage](#usage)
- ℹ️ [Programmatic Manual Operations](#programmatic-manual-operations)
- ℹ️ [Inline Blade Directive Isolation](#inline-blade-directive-isolation)
- ⚡️ [Advanced Integration with Vite & React Fast Refresh](#advanced-integration-with-vite-and-react-fast-refresh)
- 📦 [Custom Vite Architecture Mapping](#custom-vite-architecture-mapping)
- ⚙️ [Environment Tailoring Examples](#environment-tailoring-examples)
- 🛠 [How to consume these in `vite.config.js`](#how-to-consume-in-vite-config)
- 💻 [Blade Implementation Usage](#blade-implementation-usage)
- 📝 [Changelog](#changelog)
- 🤝 [Contributing](#contributing)
- ❤️ [Become a Sponsor](#become-a-sponsor)
- 🛡 [Security](#security)
- 🙌 [Credits](#credits)
- 📜 [License](#license)
- 🔗 [Framework & Reference Links](#framework--reference-links)

---

<h2 id="requirements">🛠 Requirements</h2>

| Laravel Framework & `illuminate/support` | PHP  |
| ---------------------------------------- | ---- |
| ^10.x \| ^11.x \| ^12.x \| ^13.x         | ^8.1 |

---

<h2 id="installation">⚙️ Installation</h2>

You can install the package via composer:

```bash
composer require rzl-zone/blade-minify
```

---

<h2 id="setup">🚀 Setup</h2>

### Publish config

```php
php artisan vendor:publish --tag=RzlZoneBladeMinify
```

### Add middleware to web middleware group within app/Http/Kernel.php

```php
\RzlZone\BladeMinify\Middleware\RzlBladeOutputMinifier::class
```

---

<h2 id="usage">🔥 Usage</h2>

### Enable in .env

```php
RZLZONE_MINIFY_ENABLE=true
```

### Disable in .env

```php
RZLZONE_MINIFY_ENABLE=false
```

### Minify only in production

```php
RZLZONE_MINIFY_ONLY_PROD=true
```

### Minify at all mode APP Env (default)

```php
RZLZONE_MINIFY_ONLY_PROD=false
```

### Ignore specific route names from minifying render output

```php
'ignore_route_name' => [
  // 'dashboard',
  // 'home',
]
```

---

<h2 id="programmatic-manual-operations">ℹ️ Programmatic Manual Operations</h2>

```php
use RzlZone\BladeMinify\Facades\RzlBladeMinify;

// Manually compress a raw HTML layout string
$compressedHtml = RzlBladeMinify::minify("<div>  <p>Hello World</p>  </div>");

// Explicitly isolate a string container from compression cycles
$isolatedHtml = RzlBladeMinify::ignoreMinify("<code>  preserve   whitespace  </code>");
```

---

<h2 id="inline-blade-directive-isolation">ℹ️ Inline Blade Directive Isolation</h2>

To prevent specific code segments or third-party blocks from being targeted by the regex compression loops, wrap your code inside the dedicated wrapper directive:

```blade
{{-- Everything inside this directive block remains completely raw and uncompressed --}}
@ignoreRzlzoneMinify
  <pre>
     Strictly   Preserved   Preformatted   Whitespace   Output
  </pre>
@endIgnoreRzlzoneMinify
```

---

<h2 id="advanced-integration-with-vite-and-react-fast-refresh">⚡️ Advanced Integration with Vite & React Fast Refresh</h2>

No special layout modifications or fragile workarounds are required.  
The package natively tracks, isolates, and guards core asset bundler structures—such as React Fast Refresh preambles—ensuring strict security tokens and javascript scopes are preserved post-minification.

---

<h2 id="custom-vite-architecture-mapping">📦 Custom Vite Architecture Mapping</h2>

Publishing the configuration creates the `custom-vite` block inside `config/rzlzone-blade-minify.php`. This gives you full control over customized asset folders, CSP nonces, and hot-reload file parameters:

```php
<?php

return [
  /*
    |--------------------------------------------------------------------------
    | Core Minifier Settings
    |--------------------------------------------------------------------------
    */
  'enable'              => env('RZLZONE_MINIFY_ENABLE', true),
  'run_production_only' => env('RZLZONE_MINIFY_ONLY_PROD', false),
  'ignore_route_name'   => [],

  /*
    |--------------------------------------------------------------------------
    | Custom Vite Configuration
    |--------------------------------------------------------------------------
    |
    | This array contains the configuration settings for the custom Vite asset
    | bundler integration, including build directories, CSP nonce settings,
    | and manifest/hot file tracking.
    |
    | WARNING: If you modify these values, ensure that your `vite.config.js`
    | configuration (such as build.outDir, build.manifest, or server settings)
    | is updated accordingly to match these paths and filenames.
    |
    */
  "custom-vite" => [
    /*
      |--------------------------------------------------------------------------
      | Build Directory
      |--------------------------------------------------------------------------
      |
      | This value determines the directory where compiled frontend assets
      | will be stored. The framework and asset helpers may use this path
      | when resolving built files and generated manifests.
      |
      | If changed, make sure to update the `build.outDir` in `vite.config.js`
      | (e.g., `public/custom-build-dir`).
      |
      */
    "build_dir" => env("APP_BUILD_DIR", "build"),

    /*
      |--------------------------------------------------------------------------
      | Use Asset Nonce
      |--------------------------------------------------------------------------
      |
      | This option determines whether a nonce attribute should be applied
      | to generated asset tags. Enabling this can help satisfy Content
      | Security Policy (CSP) requirements for scripts and styles.
      |
      */
    "use_nonce" => env("APP_USE_NONCE", false),

    /*
      |--------------------------------------------------------------------------
      | Build Manifest File
      |--------------------------------------------------------------------------
      |
      | This value specifies the name of the asset manifest file generated
      | by the frontend build process. The manifest is used to map original
      | asset names to their versioned counterparts.
      |
      | If changed, ensure your `vite.config.js` has a matching filename
      | via `build.manifest` configuration.
      |
      */
    "manifest_name" => __rzl_bm_get_path_file__(env("APP_BUILD_MANIFEST_NAME"), default: "manifest.json"),

    /*
      |--------------------------------------------------------------------------
      | Hot Module Replacement File
      |--------------------------------------------------------------------------
      |
      | This value defines the location of the hot file used during local
      | development. When present, the framework will use it to detect and
      | communicate with the running development server.
      |
      | If customized, you must configure Vite's plugin or server options
      | to output the hot file to this exact path.
      |
      */
    "hot_file" => __rzl_bm_get_path_file__(env("APP_HOT_FILE")) ? public_path(__rzl_bm_get_path_file__(env("APP_HOT_FILE"))) : "hot",
  ]
];
```

---

<h2 id="environment-tailoring-examples">⚙️ Environment Tailoring Examples (.env)</h2>

You can easily override your asset pipeline behavior dynamically without touching your production config file:

```bash
# Custom Asset Build Mapping
APP_BUILD_DIR="assets/dist"
APP_BUILD_MANIFEST_NAME="manifest-v2.json"

# Strict Content Security Policy (CSP) Hardening
APP_USE_NONCE=true

# Custom Dev Server Communication Target
APP_HOT_FILE="vite.hot"

# Vite Environment Bridge (Exposes these variables to vite.config.js) 
VITE_APP_BUILD_DIR="${APP_BUILD_DIR}"
VITE_APP_HOT_FILE="public/${APP_HOT_FILE}"
VITE_APP_BUILD_MANIFEST_NAME="${APP_BUILD_MANIFEST_NAME}"
```

---

<h2 id="how-to-consume-in-vite-config">🛠 How to consume these in <code>vite.config.js</code></h2>

To make your frontend build tool automatically adapt to the configuration above, load the environment variables securely and bind them to your Vite options:

```javascript
import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
  // Safely load Vite-prefixed variables into a local object
  const env = loadEnv(mode, process.cwd(), 'VITE_');

  // Check and normalize custom hot file path using the local env object
  const hotFile = env.VITE_APP_HOT_FILE?.trim();

  // Safely check length using optional chaining to prevent crashes
  const hasCustomHotFile = hotFile?.length > 0 && hotFile !== 'public/hot' && hotFile !== '/public';

  return {
    plugins: [
      laravel({
        input: ['resources/css/app.css', 'resources/js/app.js'],
        refresh: true,
        // Sync the hot file location
        hotFile: hasCustomHotFile ? hotFile : undefined,
        // Sync the build output directory (e.g., public/assets/dist)
        buildDirectory: env.VITE_APP_BUILD_DIR?.trim() || "build"
      }),
    ],
    build: {      
      // Sync the manifest filename
      manifest: env.VITE_APP_BUILD_MANIFEST_NAME?.trim() || 'manifest.json',
    },
  };
});
```

---

<h2 id="blade-implementation-usage">💻 Blade Implementation Usage</h2>

Standard framework asset directives compile seamlessly.  
The core minifier flags these tags with internal structural attributes (rzl-zone--bm) to ensure they remain safe and functional:

```blade
@viteReactRefresh
@vite(['resources/js/app.tsx'])
```

**⚠️ Configuration Sync Warning**: If you choose to modify `build_dir` or `manifest_name` within your environment configuration, ensure that your root `vite.config.js` script properties (`build.outDir`, `build.manifest`) are mirrored exactly to prevent absolute path breakdown cycles during deployments.

---

<h2 id="changelog">📝 Changelog</h2>

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

---

<h2 id="contributing">🤝 Contributing</h2>

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

---

<h2 id="become-a-sponsor">❤️ Become a Sponsor</h2>

[Become a sponsor to Rzl App](https://github.com/sponsors/rzl-app).

---

---

<h2 id="security">🛡 Security</h2>

Please report issues to [rzlzone.dev@gmail.com](mailto:rzlzone.dev@gmail.com).

---

<h2 id="credits">🙌 Credits</h2>

- [Rzl App](https://github.com/rzl-app)
- [All Contributors](../../contributors)

---

##

<h2 id="license">📜 License</h2>

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---

<h2 id="framework--reference-links">🔗 Framework & Reference Links</h2>

| Reference             | URL                                                                                                                                            |
| --------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------- |
| 📝 Laravel Docs       | [https://laravel.com/docs](https://laravel.com/docs)                                                                                           |
| 🏗 Illuminate\Support  | [https://github.com/laravel/framework/tree/13.x/src/Illuminate/Support](https://github.com/laravel/framework/tree/13.x/src/Illuminate/Support) |
| 🐘 PHP Official       | [https://www.php.net](https://www.php.net)                                                                                                     |

---

✅ **Enjoy `rzl-zone/blade-minify`?**  
Leave a ⭐ on GitHub — it keeps this project thriving!

---

✨ From [rzl-zone](https://github.com/rzl-zone) — _where code meets passion._

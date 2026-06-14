# ⚡️Rzl Zone - Blade Minifier 🚀

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rzl-zone/blade-minify.svg?style=flat-rounded)](https://packagist.org/packages/rzl-zone/blade-minify)
[![Total Downloads](https://img.shields.io/packagist/dt/rzl-zone/blade-minify.svg?style=flat-rounded)](https://packagist.org/packages/rzl-zone/blade-minify)
[![PHPStan](https://img.shields.io/badge/phpstan-level%208-brightgreen?style=flat-rounded)](https://phpstan.org)
[![PHP](https://img.shields.io/badge/PHP-^8.2-blue?style=flat-rounded)](https://www.php.net)
[![Laravel](https://img.shields.io/badge/Laravel-^10.x%20|%20^11.x%20|%20^12.x|%20^13.x-red?style=flat-rounded)](https://laravel.com)
[![Illuminate Support](https://img.shields.io/badge/illuminate%2Fsupport-^10.x%20|%20^11.x%20|%20^12.x|%20^13.x-blue?style=flat-rounded)](https://laravel.com/docs)
[![GitHub](https://img.shields.io/badge/GitHub-rzl--app%2Fblade--minify-181717?logo=github)](https://github.com/rzl-zone/blade-minify)
[![Repo on GitHub](https://img.shields.io/badge/Repo-on%20GitHub-181717?logo=github&style=flat-rounded)](https://github.com/rzl-zone)

> 🚀 **Automatically minifies your Laravel Blade output for smaller pages & blazing-fast load times.**
>
> 🛠 **Supports:**
>
> - 📚 [Laravel Docs](https://laravel.com/docs) — for official usage
> - 🧩 [`Illuminate\Support`](https://github.com/laravel/framework/tree/13.x/src/Illuminate/Support)
> - 🐘 PHP ^8.2 + Laravel ^10.x | ^11.x | ^12.x | ^13.x\| ^13.x
>
> **Built with ❤️ by [@rzl-zone](https://github.com/rzl-zone).**

---

## 📚 Table of Contents

- 🛠 [Requirements](#requirements)
- ⚙️ [Installation](#installation)
- 🚀 [Setup](#setup)
- 🔥 [Usage](#usage)
- 📝 [Changelog](#changelog)
- 🤝 [Contributing](#contributing)
- 🛡 [Security](#security)
- 🙌 [Credits](#credits)
- 📜 [License](#license)
- 🔗 [Framework & Reference Links](#framework--reference-links)

---

<h2 id="requirements">🛠 Requirements</h2>

| Laravel Framework & `illuminate/support` | PHP  | Package |
| ---------------------------------------- | ---- | ------- |
| ^10.x \| ^11.x \| ^12.x \| ^13.x         | ^8.2 | v1.x    |

---

<h2 id="installation">⚙️ Installation</h2>

You can install the package via composer:

```bash
composer require rzl-zone/blade-minify
```

## Sponsor Rzl Laravel Blade Minifier on GitHub

[Become a sponsor to Rzl App](https://github.com/sponsors/rzl-app).

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

### Minify a particular Blade string manually

```php
RzlBladeMinify::minify("<div>...</div>");
```

### Ignoring minify a particular Blade string manually

```php
RzlBladeMinify::excludeMinify("<div>...</div>");
```

### Ignore minify in Blade

```php
{{-- Blade directive to ignore minify --}}

@ignoreRzlzoneMinify
  <div> this script will ignored from minify   </div>
@endIgnoreRzlzoneMinify

```

### Working with Vite & Laravel Boost

No special handling is required.

```blade
@viteReactRefresh
@vite(['resources/js/app.js'])
```

The package automatically handles Vite, React Refresh, and Laravel Boost output, ensuring they remain compatible with Blade minification out of the box.

If needed, you can still use the `@ignoreRzlzoneMinify` directive for custom sections that should not be processed by the minifier:

```blade
@ignoreRzlzoneMinify
    <pre>{{ $debugOutput }}</pre>
@endIgnoreRzlzoneMinify
```

This is entirely optional and is only recommended for custom edge cases or debugging purposes.

---

<h2 id="changelog">📝 Changelog</h2>

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

---

<h2 id="contributing">🤝 Contributing</h2>

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

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

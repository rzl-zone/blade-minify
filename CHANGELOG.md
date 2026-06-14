# Changelog

## All notable changes to `rzl-zone/blade-minify` will be documented in this file.

## v0.0.3

Bug fix release.

### Fixed

* Fixed `RzlBladeOutputMinifier` middleware compatibility with non-HTML responses.
* Fixed type handling for `JsonResponse` and other Symfony/Laravel response types.
* Prevented middleware exceptions when processing API, Inertia, and JSON responses.

### Improvements

* Improved response type detection before applying HTML minification.
* Increased middleware stability across different Laravel response implementations.

### Notes

This release fixes an issue where the `RzlBladeOutputMinifier` middleware could throw a `TypeError` when handling `JsonResponse` instances instead of standard HTML responses.

**Full Changelog**: <https://github.com/rzl-zone/blade-minify/compare/v0.0.2...v0.0.3>

---

## v0.0.2

Bug fix release.

### Fixed

* Fixed incorrect namespace resolution in custom `@vite` Blade directive registration.
* Fixed incorrect namespace resolution in custom `@viteReactRefresh` Blade directive registration.
* Improved custom Vite integration stability.

### Notes

This release resolves issues affecting custom Vite directive registration and rendering.

**Full Changelog**: <https://github.com/rzl-zone/blade-minify/compare/v0.0.1...v0.0.2>

---

## v0.0.1

Initial public release for testing and package distribution.

### Features

* Blade output minification support
* `@ignoreRzlzoneMinify` and `@endIgnoreRzlzoneMinify` directives
* Laravel 10, 11, 12 and 13 support
* Vite compatibility
* Laravel Boost compatibility
* Middleware integration for automatic response minification

### Notes

This is an initial testing release intended to verify package installation, autoloading, service provider registration, and Packagist distribution.

Feedback and bug reports are welcome.

**Full Changelog**: <https://github.com/rzl-zone/blade-minify/commits/v0.0.1>

---

# Changelog

## All notable changes to `rzl-zone/blade-minify` will be documented in this file.

## v0.0.5

Core architecture lockdown, internal attribute tracking, and strict finalization for classes and constants.

### Added

* Added support class `\RzlZone\BladeMinify\Support\RzlBladeInternalAttribute` to manage internal marker attributes.

### Improvements

* Enhanced the `\RzlZone\BladeMinify\Minifier\RzlBladeMinifier::minify` core process to automatically inject the `INTERNAL_ATTRIBUTE_KEY` into `style` and `script` tags that contain non-empty strings.

### Changed

* Changed `RzlBladeMinifier` to a `final class` to ensure the core minification logic cannot be overridden.
* Changed `IGNORE_START` and `IGNORE_END` constants in the `IgnoreMinifyBladeCompiler` class to `final const` for strict PHP 8.1 compatibility and architectural safety.
* Updated `readme.md` to reflect recent changes to the core architecture and internal processes.

### Notes

This release focuses on securing the core architecture by leveraging PHP 8.1's `final` capabilities for both classes and constants. It also introduces a new internal attribute injection system for non-empty scripts and styles to improve tracking and processing reliability during the minification cycle.

**Full Changelog**: <https://github.com/rzl-zone/blade-minify/compare/v0.0.4...v0.0.5>

---

## v0.0.4

Architecture refactor, minifier engine enhancements, and PHP 8.1 support.

### Fixed

* Fixed script processing and validation logic inside the `RzlBladeOutputMinifier` middleware.
* Fixed method return types to ensure full compatibility with PHP 8.1.

### Improvements

* Downgraded the minimum PHP version requirement to `8.1` to support a wider range of projects.
* Upgraded the `RzlBladeMinifier` core logic for optimal `\n` control between tags and safer inline JS/CSS handling.
* Enhanced minifier safety for `script`, `style`, `pre`, `textarea`, structural JSON configurations, and plain template strings.
* Revamped internal script handling for `CustomVite` based on the `custom-vite` configuration, including default provider fixes.

### Changed

* Renamed global file `Internal-helper.php` to `InternalHelper.php`.
* Renamed public method `RzlBladeMinify::excludeMinify` to `RzlBladeMinify::ignoreMinify`.
* Renamed `ViteCustom` to `CustomVite` and `ViteCustomProvider` to `CustomViteProvider`.
* Updated the `"custom-vite"` configuration array structure.
* Updated `readme.md` to reflect recent architecture and configuration changes.

### Removed

* Removed custom `BoostServiceProvider`. It is no longer needed as the core minifier now natively handles inline JS/CSS without requiring invalid asset overrides.

### Notes

This release focuses on broadening PHP compatibility back to 8.1 while massively improving the minifier's core engine to safely parse complex inline scripts and styles. Significant architectural renaming was also implemented to standardize the codebase, culminating in the removal of redundant custom providers.

**Full Changelog**: <https://github.com/rzl-zone/blade-minify/compare/v0.0.3...v0.0.4>

---

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

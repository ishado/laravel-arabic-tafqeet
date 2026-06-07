# Changelog

All notable changes to `alkoumi/laravel-arabic-tafqeet` are documented in this file.

---

## [v2.0.0] — 2026-06-07

### Added

- **`Tafqeet::inArabicNumber()`** — Convert a pure number to Arabic words without currency.
- **`Tafqeet::inArabicCurrency()`** — Explicit API for currency conversion (alias for `inArabic()`).
- **`Tafqeet::inArabicFormatted()`** — Flexible formatting with optional prefix and suffix.
- **`Config::addCurrency()`** — Register custom currencies at runtime.
- **`Config::supportedCurrencies()`** — Returns all supported currency codes.
- **Comprehensive test suite**: 96 tests covering 16 currencies, edge cases, Arabic grammar rules, and new features.
- Support for large numbers (billions, trillions) via ICU/`NumberFormatter`.
- `extra.laravel.aliases` in `composer.json` for auto-discovery in Laravel 5.5+.
- `.gitattributes` to exclude dev files from distribution.

### Changed

- **PHP requirement raised** from implicit to `>=8.0`.
- **`illuminate/support`** explicitly declared as a dependency (`^7.0 || ^8.0 || ^9.0 || ^10.0 || ^11.0`).
- **`ext-intl`** explicitly declared as a requirement.
- `$config` extracted from `Tafqeet` to a standalone `Config` class.
- `detectClass()` refactored from if-chain to array map.
- `\NumberFormatter` instance cached (created once, reused).
- Full PHP 8.0+ type hints added throughout the codebase.
- Dead code removed: `getNameOfHala()`, `//dd()` comments, `test.php`.
- `$after_comma_sum` initialised as `''` instead of `null`.
- `AliasLoader` guarded with `class_exists()` for Laravel 11 compatibility.
- ServiceProvider uses modern return types.

### Fixed

- Missing `composer.json` `require` section that caused silent breakage.
- PHP 8.4 compatibility verified (tests pass on ICU 77.1).

### Deprecated

- **`Tafqeet::$config`** visibility changed to `protected`. Use `Config::get()` instead.
- `inArabic()` still works as a backward-compatible alias for `inArabicCurrency()`.

### Removed

- `test.php` (informal test file in project root).
- Dead trait method `getNameOfHala()` in `Digit.php`.

---

## [v1.4.0] — 2021-02-04

- Last release by original author. See git history for details.

---

## [v1.0.0] — 2019-12-19

- Initial release: currency-aware Arabic number-to-text conversion.
- 16 supported currencies.
- `Tafqeet::inArabic($amount, $currency)` public API.

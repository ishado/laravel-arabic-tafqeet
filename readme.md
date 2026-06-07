# Laravel Arabic Tafqeet  تفقيط الأرقام باللغة العربية

[![License](https://poser.pugx.org/alkoumi/laravel-arabic-tafqeet/license)](https://packagist.org/packages/alkoumi/laravel-arabic-tafqeet)
[![Latest Stable Version](https://poser.pugx.org/alkoumi/laravel-arabic-tafqeet/v/stable)](https://packagist.org/packages/alkoumi/laravel-arabic-tafqeet)
[![Total Downloads](https://poser.pugx.org/alkoumi/laravel-arabic-tafqeet/downloads)](https://packagist.org/packages/alkoumi/laravel-arabic-tafqeet)

Convert monetary amounts and pure numbers into their Arabic textual form (Tafqeet / تفقيط).

## Requirements

- PHP >= 8.0
- `ext-intl` (Internationalization extension)
- Laravel >= 7.0 (or `illuminate/support`)

## Installation

```bash
composer require alkoumi/laravel-arabic-tafqeet
```

The package uses Laravel auto-discovery. No manual registration is needed.

---

## Usage

### Convert amounts with currency

```php
use Alkoumi\LaravelArabicTafqeet\Tafqeet;

// Default currency: SAR
Tafqeet::inArabic(3150.9);
// "فقط ثلاثة آلاف ومائة وخمسون ريال وتسعة هللات لا غير"
// (nine halalas because 3150.90 → the decimal part is 90)

// Egyptian Pounds
Tafqeet::inArabic(3150.9, 'egp');
// "فقط ثلاثة آلاف ومائة وخمسون جنيه وتسعة قروش لا غير"

// US Dollars
Tafqeet::inArabic(100, 'usd');
// "فقط مائة دولار لا غير"
```

> **Arabic grammar note:** The currency name changes form automatically based on the number — *marfūʿ* (رفع, e.g. "ريال") for 1, 2, 11, 12… and *manṣūb* (نصب, e.g. "ريالاً") for 3−10, 100…. This is handled implicitly by the package with no extra configuration needed.

### Convert pure numbers (no currency)

```php
Tafqeet::inArabicNumber(1234);
// "ألف ومائتان وأربعة وثلاثون"

Tafqeet::inArabicNumber(0);
// "صفر"
```

### Explicit currency method

```php
Tafqeet::inArabicCurrency(500, 'sar');
// "فقط خمسمائة ريال لا غير"
```

### Flexible formatting

Control the prefix and suffix bookend words:

```php
// Omit "فقط" and "لا غير"
Tafqeet::inArabicFormatted(100, 'sar', null, null);
// "مائة ريال"

// Custom prefix only
Tafqeet::inArabicFormatted(100, 'sar', 'المبلغ', null);
// "المبلغ مائة ريال"

// Custom both
Tafqeet::inArabicFormatted(100, 'sar', 'المبلغ', 'تماماً');
// "المبلغ مائة ريال تماماً"

// Keep the default "فقط" prefix, customize only the suffix
Tafqeet::inArabicFormatted(100, 'sar', '{default}', 'تماماً');
// "فقط مائة ريال تماماً"
```

> `{default}` preserves the built-in prefix/suffix, while `null` omits it entirely.

### Custom currencies

```php
use Alkoumi\LaravelArabicTafqeet\Config;

Config::addCurrency('try', 'ليرة', 'ليرة', 'قرش', 'قروش');

Tafqeet::inArabicCurrency(100, 'try');
// "فقط مائة ليرة لا غير"
```

### List supported currencies

```php
Config::supportedCurrencies();
// ['sar', 'egp', 'dzd', 'aed', 'kwd', 'bhd', 'iqd', 'lbp', 'yer', 'jod', 'usd', 'sdg', 'mad', 'tnd', 'qar', 'omr']
```

---

## Supported Currencies

| Code | Currency | Major Unit | Minor Unit |
|------|----------|------------|------------|
| `sar` | Saudi Riyal | ريال | هللة / هللات |
| `egp` | Egyptian Pound | جنيه / جنيهًا | قرش / قروش |
| `dzd` | Algerian Dinar | دينار / دينارًا | سنتيم / سنتيمات |
| `aed` | UAE Dirham | درهم / درهمًا | فلس / فلسات |
| `kwd` | Kuwaiti Dinar | دينار / دينارًا | فلس / فلسات |
| `bhd` | Bahraini Dinar | دينار / دينارًا | فلس / فلسات |
| `iqd` | Iraqi Dinar | دينار / دينارًا | فلس / فلسات |
| `lbp` | Lebanese Pound | ليرة | قرش / قروش |
| `yer` | Yemeni Riyal | ريال / ريالًا | فلس / فلسات |
| `jod` | Jordanian Dinar | دينار / دينارًا | قرش / قروش |
| `usd` | US Dollar | دولار / دولاراً | سنت |
| `sdg` | Sudanese Pound | قرش / قرشاً | قرش / قروش |
| `mad` | Moroccan Dirham | درهم / درهمًا | سنتيم / سنتيمات |
| `tnd` | Tunisian Dinar | دينار / دينارًا | مليم / مليمات |
| `qar` | Qatari Riyal | ريال / ريالًا | درهم / دراهم |
| `omr` | Omani Riyal | ريال / ريالًا | بيسة / بيسات |

Add more with `Config::addCurrency()`.

---

## Large Numbers

The package supports numbers up to trillions via PHP's `NumberFormatter` (ICU):

```php
Tafqeet::inArabicCurrency(1234567890, 'sar');
// includes "مليار"

Tafqeet::inArabicNumber(999999999999);
// includes "مليار"
```

---

## Backward Compatibility

- `Tafqeet::inArabic($amount, $currency)` is fully preserved.
- Laravel 5.5 through 11.x are supported.

For the full changelog, see [CHANGELOG.md](CHANGELOG.md).

---

## Testing

```bash
./vendor/bin/phpunit
```

The package includes 96 tests covering all 16 currencies, edge cases, Arabic grammar rules, and the full public API.

---

#### ☕️ Support: https://patreon.com/mohammadelkoumi

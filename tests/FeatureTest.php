<?php

namespace Alkoumi\LaravelArabicTafqeet\Tests;

use Alkoumi\LaravelArabicTafqeet\Config;
use Alkoumi\LaravelArabicTafqeet\Tafqeet;

class FeatureTest extends TestCase
{
    // ─── inArabicNumber ──────────────────────────────────────

    /** @testdox inArabicNumber converts zero */
    public function testInArabicNumberZero(): void
    {
        $this->assertSame('صفر', Tafqeet::inArabicNumber(0));
    }

    /** @testdox inArabicNumber converts basic numbers */
    /** @dataProvider inArabicNumberProvider */
    public function testInArabicNumber($number, $expected): void
    {
        $this->assertStringStartsWith($expected, Tafqeet::inArabicNumber($number));
    }

    public static function inArabicNumberProvider(): array
    {
        return [
            'one'    => [1,          'واحد'],
            'hundred' => [100,       'مائة'],
            'thousand' => [1000,     'ألف'],
            'million'  => [1000000,  'مليون'],
            'billion'  => [1000000000, 'مليار'],
        ];
    }

    /** @testdox inArabicNumber handles decimals via NumberFormatter */
    public function testInArabicNumberWithDecimals(): void
    {
        $this->assertStringStartsWith('واحد', Tafqeet::inArabicNumber(1.5));
    }

    // ─── inArabicCurrency ────────────────────────────────────

    /** @testdox inArabicCurrency is same as inArabic */
    public function testInArabicCurrencySameAsInArabic(): void
    {
        $amount = 1234.56;
        $currency = 'usd';

        $this->assertSame(
            Tafqeet::inArabic($amount, $currency),
            Tafqeet::inArabicCurrency($amount, $currency)
        );
    }

    /** @testdox inArabicCurrency works with SAR */
    public function testInArabicCurrencyWithSar(): void
    {
        $this->assertSame(
            'فقط مائة ريال لا غير',
            Tafqeet::inArabicCurrency(100, 'sar')
        );
    }

    /** @testdox inArabicCurrency works with USD decimals */
    public function testInArabicCurrencyWithDecimals(): void
    {
        $this->assertStringContainsString('دولار', Tafqeet::inArabicCurrency(1.5, 'usd'));
        $this->assertStringContainsString('سنت', Tafqeet::inArabicCurrency(1.5, 'usd'));
    }

    // ─── inArabicFormatted ───────────────────────────────────

    /** @testdox inArabicFormatted default behaviour matches inArabic */
    public function testFormattedDefaultMatchesInArabic(): void
    {
        $this->assertSame(
            Tafqeet::inArabic(100, 'sar'),
            Tafqeet::inArabicFormatted(100, 'sar')
        );
    }

    /** @testdox inArabicFormatted with null starter/end removes bookends */
    public function testFormattedWithoutBookends(): void
    {
        $result = Tafqeet::inArabicFormatted(100, 'sar', null, null);
        $this->assertStringNotContainsString('فقط', $result);
        $this->assertStringNotContainsString('لا غير', $result);
    }

    /** @testdox inArabicFormatted with custom starter */
    public function testFormattedWithCustomStarter(): void
    {
        $result = Tafqeet::inArabicFormatted(100, 'sar', 'المبلغ', null);
        $this->assertStringStartsWith('المبلغ', $result);
        $this->assertStringNotContainsString('فقط', $result);
    }

    /** @testdox inArabicFormatted with custom end */
    public function testFormattedWithCustomEnd(): void
    {
        $result = Tafqeet::inArabicFormatted(100, 'sar', null, 'تماماً');
        $this->assertStringEndsWith('تماماً', $result);
        $this->assertStringNotContainsString('لا غير', $result);
    }

    /** @testdox inArabicFormatted with both custom bookends */
    public function testFormattedWithBothCustomBookends(): void
    {
        $result = Tafqeet::inArabicFormatted(100, 'sar', 'المبلغ', 'تماماً');
        $this->assertStringStartsWith('المبلغ', $result);
        $this->assertStringEndsWith('تماماً', $result);
        $this->assertStringNotContainsString('فقط', $result);
        $this->assertStringNotContainsString('لا غير', $result);
    }

    // ─── Config::addCurrency ─────────────────────────────────

    /** @testdox Config::addCurrency registers a new currency at runtime */
    public function testAddCustomCurrency(): void
    {
        Config::addCurrency('try', 'ليرة', 'ليرة', 'قرش', 'قروش');

        $result = Tafqeet::inArabicCurrency(100, 'try');
        $this->assertStringContainsString('ليرة', $result);
    }

    /** @testdox Config::addCurrency with decimal amount */
    public function testCustomCurrencyWithDecimals(): void
    {
        Config::addCurrency('xxx', 'وحدة', 'وحدة', 'جزء', 'أجزاء');

        $result = Tafqeet::inArabicCurrency(1.5, 'xxx');
        $this->assertStringContainsString('وحدة', $result);
        $this->assertStringContainsString('أجزاء', $result);
    }

    /** @testdox Config::supportedCurrencies returns all codes */
    public function testSupportedCurrencies(): void
    {
        $currencies = Config::supportedCurrencies();

        $this->assertContains('sar', $currencies);
        $this->assertContains('usd', $currencies);
        $this->assertContains('egp', $currencies);
    }

    // ─── Large numbers (ICU-dependent) ───────────────────────

    /** @testdox inArabicCurrency handles 10-digit numbers */
    public function testLargeNumberTenDigits(): void
    {
        $result = Tafqeet::inArabicCurrency(1234567890, 'sar');
        $this->assertStringContainsString('مليار', $result);
        $this->assertStringContainsString('ريال', $result);
    }

    /** @testdox inArabicCurrency handles 12-digit numbers */
    public function testLargeNumberTwelveDigits(): void
    {
        $result = Tafqeet::inArabicCurrency(999999999999, 'sar');
        $this->assertStringContainsString('مليار', $result);
        $this->assertStringContainsString('ريال', $result);
    }
}

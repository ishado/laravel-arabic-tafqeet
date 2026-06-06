<?php

namespace Alkoumi\LaravelArabicTafqeet\Tests;

use Alkoumi\LaravelArabicTafqeet\Tafqeet;

class RegressionTest extends TestCase
{
    /**
     * @testdox SAR (ريال سعودي) — tests de base
     * @dataProvider sarProvider
     */
    public function testSarCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'sar'));
    }

    public static function sarProvider(): array
    {
        return [
            'zero'               => [0,        'فقط صفر ريال لا غير'],
            'one'                => [1,        'فقط واحد ريال لا غير'],
            'two'                => [2,        'فقط إثنان ريال لا غير'],
            'three'              => [3,        'فقط ثلاثة ريال لا غير'],
            'ten'                => [10,       'فقط عشرة ريال لا غير'],
            'eleven'             => [11,       'فقط إحدى عشر ريال لا غير'],
            'twelve'             => [12,       'فقط إثنا عشر ريال لا غير'],
            'twenty one'         => [21,       'فقط واحد وعشرون ريال لا غير'],
            'hundred'            => [100,      'فقط مائة ريال لا غير'],
            'two hundred'        => [200,      'فقط مائتان ريال لا غير'],
            'thousand'           => [1000,     'فقط ألف ريال لا غير'],
            'five thousand'      => [5000,     'فقط خمسة آلاف ريال لا غير'],
            'million'            => [1000000,  'فقط مليون ريال لا غير'],
            'original test case' => [3150.9,   'فقط ثلاثة آلاف ومائة وخمسون ريال وتسعة هللات لا غير'],
        ];
    }

    /**
     * @testdox EGP (جنيه مصري)
     * @dataProvider egpProvider
     */
    public function testEgpCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'egp'));
    }

    public static function egpProvider(): array
    {
        return [
            'five'             => [5,        'فقط خمسة جنيه لا غير'],
            'one point five'   => [1.5,      'فقط واحد جنيه وخمسة قروش لا غير'],
            'one twenty point five five' => [120.55, 'فقط مائة وعشرون جنيه وخمسة وخمسون قرش لا غير'],
            'million'          => [1000000,  'فقط مليون جنيه لا غير'],
        ];
    }

    /**
     * @testdox USD (دولار أمريكي)
     * @dataProvider usdProvider
     */
    public function testUsdCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'usd'));
    }

    public static function usdProvider(): array
    {
        return [
            'zero point zero one' => [0.01, 'فقط صفر دولار وواحد سنت لا غير'],
            'two'                 => [2,    'فقط إثنان دولار لا غير'],
            'two point zero one'  => [2.01, 'فقط إثنان دولار وواحد سنت لا غير'],
            'twelve point three four' => [12.34, 'فقط إثنا عشر دولار وأربعة وثلاثون سنت لا غير'],
            'thousand'            => [1000, 'فقط ألف دولار لا غير'],
        ];
    }

    /**
     * @testdox KWD (دينار كويتي)
     * @dataProvider kwdProvider
     */
    public function testKwdCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'kwd'));
    }

    public static function kwdProvider(): array
    {
        return [
            '777.77' => [777.77, 'فقط سبعة مائة وسبعة وسبعون دينارًا وسبعة وسبعون فلس لا غير'],
            '1420.75' => [1420.75, 'فقط ألف وأربعة مائة وعشرون دينار وخمسة وسبعون فلس لا غير'],
        ];
    }

    /**
     * @testdox BHD (دينار بحريني)
     * @dataProvider bhdProvider
     */
    public function testBhdCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'bhd'));
    }

    public static function bhdProvider(): array
    {
        return [
            'zero' => [0, 'فقط صفر دينار لا غير'],
            '987654.32' => [987654.32, 'فقط تسعة مائة وسبعة وثمانون ألف وستة مائة وأربعة وخمسون دينار واثنان وثلاثون فلس لا غير'],
        ];
    }

    /**
     * @testdox IQD (دينار عراقي)
     * @dataProvider iqdProvider
     */
    public function testIqdCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'iqd'));
    }

    public static function iqdProvider(): array
    {
        return [
            'hundred'  => [100,     'فقط مائة دينار لا غير'],
            'five million' => [5000000, 'فقط خمسة مليون دينار لا غير'],
        ];
    }

    /**
     * @testdox LBP (ليرة لبنانية)
     * @dataProvider lbpProvider
     */
    public function testLbpCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'lbp'));
    }

    public static function lbpProvider(): array
    {
        return [
            'million'  => [1000000, 'فقط مليون ليرة لا غير'],
            '250000' => [250000, 'فقط مائتان وخمسون ألف ليرة لا غير'],
        ];
    }

    /**
     * @testdox YER (ريال يمني)
     * @dataProvider yerProvider
     */
    public function testYerCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'yer'));
    }

    public static function yerProvider(): array
    {
        return [
            '555' => [555, 'فقط خمسة مائة وخمسة وخمسون ريال لا غير'],
            '852147' => [852147, 'فقط ثمانية مائة وإثنان وخمسون ألف ومائة وسبعة وأربعون ريال لا غير'],
        ];
    }

    /**
     * @testdox JOD (دينار أردني)
     * @dataProvider jodProvider
     */
    public function testJodCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'jod'));
    }

    public static function jodProvider(): array
    {
        return [
            '77.77' => [77.77, 'فقط سبعة وسبعون دينارًا وسبعة وسبعون قرش لا غير'],
            '456789' => [456789, 'فقط أربعة مائة وستة وخمسون ألف وسبعة مائة وتسعة وثمانون دينار لا غير'],
        ];
    }

    /**
     * @testdox SDG (جنيه سوداني)
     * @dataProvider sdgProvider
     */
    public function testSdgCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'sdg'));
    }

    public static function sdgProvider(): array
    {
        return [
            'zero point five' => [0.5, 'فقط صفر قرش وخمسة قروش لا غير'],
            '1500.25' => [1500.25, 'فقط ألف وخمسة مائة قرش وخمسة وعشرون قرش لا غير'],
        ];
    }

    /**
     * @testdox MAD (درهم مغربي)
     * @dataProvider madProvider
     */
    public function testMadCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'mad'));
    }

    public static function madProvider(): array
    {
        return [
            'zero point nine' => [0.9, 'فقط صفر درهم وتسعة سنتيمات لا غير'],
            '753159' => [753159, 'فقط سبعة مائة وثلاثة وخمسون ألف ومائة وتسعة وخمسون درهم لا غير'],
        ];
    }

    /**
     * @testdox TND (دينار تونسي)
     * @dataProvider tndProvider
     */
    public function testTndCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'tnd'));
    }

    public static function tndProvider(): array
    {
        return [
            '999' => [999, 'فقط تسعة مائة وتسعة وتسعون دينار لا غير'],
        ];
    }

    /**
     * @testdox QAR (ريال قطري)
     * @dataProvider qarProvider
     */
    public function testQarCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'qar'));
    }

    public static function qarProvider(): array
    {
        return [
            '15' => [15, 'فقط خمسة عشر ريال لا غير'],
        ];
    }

    /**
     * @testdox OMR (ريال عماني)
     * @dataProvider omrProvider
     */
    public function testOmrCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'omr'));
    }

    public static function omrProvider(): array
    {
        return [
            '88.88' => [88.88, 'فقط ثمانية وثمانون ريالًا وثمانية وثمانون بيسة لا غير'],
        ];
    }

    /**
     * @testdox DZD (دينار جزائري)
     * @dataProvider dzdProvider
     */
    public function testDzdCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'dzd'));
    }

    public static function dzdProvider(): array
    {
        return [
            '9999'  => [9999,  'فقط تسعة آلاف وتسعة مائة وتسعة وتسعون دينار لا غير'],
            '99.99' => [99.99, 'فقط تسعة وتسعون دينارًا وتسعة وتسعون سنتيم لا غير'],
        ];
    }

    /**
     * @testdox AED (درهم إماراتي)
     * @dataProvider aedProvider
     */
    public function testAedCurrency($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'aed'));
    }

    public static function aedProvider(): array
    {
        return [
            '1234.56' => [1234.56, 'فقط ألف ومائتان وأربعة وثلاثون درهم وستة وخمسون فلس لا غير'],
        ];
    }

    // ─── Edge Cases ──────────────────────────────────────────────

    /**
     * @testdox Edge case: zéro avec différentes devises
     * @dataProvider zeroProvider
     */
    public function testZeroWithCurrencies($amount, $currency, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, $currency));
    }

    public static function zeroProvider(): array
    {
        return [
            'SAR' => [0, 'sar', 'فقط صفر ريال لا غير'],
            'EGP' => [0, 'egp', 'فقط صفر جنيه لا غير'],
            'USD' => [0, 'usd', 'فقط صفر دولار لا غير'],
            'BHD' => [0, 'bhd', 'فقط صفر دينار لا غير'],
            'SDG' => [0, 'sdg', 'فقط صفر قرش لا غير'],
            'MAD' => [0, 'mad', 'فقط صفر درهم لا غير'],
        ];
    }

    /**
     * @testdox Edge case: nombres à 9 chiffres (limite actuelle)
     * @dataProvider largeNumbersProvider
     */
    public function testNineDigitNumbers($amount, $currency, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, $currency));
    }

    public static function largeNumbersProvider(): array
    {
        return [
            '999999999 SAR' => [999999999, 'sar', 'فقط تسعة مائة وتسعة وتسعون مليون وتسعة مائة وتسعة وتسعون ألف وتسعة مائة وتسعة وتسعون ريال لا غير'],
            '123456789 SAR' => [123456789, 'sar', 'فقط مائة وثلاثة وعشرون مليون وأربعة مائة وستة وخمسون ألف وسبعة مائة وتسعة وثمانون ريال لا غير'],
        ];
    }

    /**
     * @testdox Edge case: précision décimale — float 1.234 tronqué à 23
     * @dataProvider decimalPrecisionProvider
     */
    public function testDecimalPrecision($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'sar'));
    }

    public static function decimalPrecisionProvider(): array
    {
        return [
            '1.234 truncated to 23' => [1.234, 'فقط واحد ريال وثلاثة وعشرون هللة لا غير'],
            '1.235 truncated to 23' => [1.235, 'فقط واحد ريال وثلاثة وعشرون هللة لا غير'],
        ];
    }

    /**
     * @testdox Edge case: entrées non numériques lèvent TypeError
     */
    public function testNonNumericThrowsTypeError(): void
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('The amount must be a numeric.');

        Tafqeet::inArabic('abc');
    }

    /**
     * @testdox Edge case: 100,000
     */
    public function testOneHundredThousand(): void
    {
        $this->assertSame(
            'فقط مائة ألف ريال لا غير',
            Tafqeet::inArabic(100000, 'sar')
        );
    }

    /**
     * @testdox Edge case: nombres spéciaux 11 et 12 dans la partie décimale
     * @dataProvider specialAfterCommaProvider
     */
    public function testSpecialAfterCommaNumbers($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'sar'));
    }

    public static function specialAfterCommaProvider(): array
    {
        return [
            '1.11' => [1.11, 'فقط واحد ريال وأحد عشر هللة لا غير'],
            '1.12' => [1.12, 'فقط واحد ريال واثنا عشر هللة لا غير'],
        ];
    }

    /**
     * @testdox Edge case: devise par défaut (SAR)
     */
    public function testDefaultCurrencyIsSar(): void
    {
        $this->assertSame(
            'فقط مائة ريال لا غير',
            Tafqeet::inArabic(100)
        );
    }

    // ─── Tests de grammaire arabe (is_main1_currency) ────────────

    /**
     * @testdox Grammaire: nombres terminant par 1-2 → ريال (main1)
     * @dataProvider main1CurrencyProvider
     */
    public function testMain1CurrencyUsedWhenEndingWithOneOrTwo($amount, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, 'sar'));
    }

    public static function main1CurrencyProvider(): array
    {
        return [
            '1'    => [1,    'فقط واحد ريال لا غير'],
            '2'    => [2,    'فقط إثنان ريال لا غير'],
            '21'   => [21,   'فقط واحد وعشرون ريال لا غير'],
            '101'  => [101,  'فقط مائة وواحد ريال لا غير'],
            '1001' => [1001, 'فقط ألف وواحد ريال لا غير'],
            '10'   => [10,   'فقط عشرة ريال لا غير'],
        ];
    }

    /**
     * @testdox Grammaire: ريالاً (main2) quand le bloc décimal correspond aux 2 derniers chiffres
     * @dataProvider main2CurrencyProvider
     */
    public function testMain2CurrencyWhenAfterCommaMatchesLastTwoDigits($amount, $currency, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, $currency));
    }

    public static function main2CurrencyProvider(): array
    {
        return [
            '999999.99 SAR' => [999999.99, 'sar', 'فقط تسعة مائة وتسعة وتسعون ألف وتسعة مائة وتسعة وتسعون ريالاً وتسعة وتسعون هللة لا غير'],
            '888888.88 SAR' => [888888.88, 'sar', 'فقط ثمانية مائة وثمانية وثمانون ألف وثمانية مائة وثمانية وثمانون ريالاً وثمانية وثمانون هللة لا غير'],
            '99.99 DZD'     => [99.99, 'dzd', 'فقط تسعة وتسعون دينارًا وتسعة وتسعون سنتيم لا غير'],
            '88.88 OMR'     => [88.88, 'omr', 'فقط ثمانية وثمانون ريالًا وثمانية وثمانون بيسة لا غير'],
            '77.77 JOD'     => [77.77, 'jod', 'فقط سبعة وسبعون دينارًا وسبعة وسبعون قرش لا غير'],
            '77.77 KWD'     => [777.77, 'kwd', 'فقط سبعة مائة وسبعة وسبعون دينارًا وسبعة وسبعون فلس لا غير'],
        ];
    }

    /**
     * @testdox Grammaire: main1 reste actif quand la décimale ne correspond pas
     * @dataProvider main1WhenNoDecimalMatchProvider
     */
    public function testMain1WhenAfterCommaDoesNotMatch($amount, $currency, $expected): void
    {
        $this->assertSame($expected, Tafqeet::inArabic($amount, $currency));
    }

    public static function main1WhenNoDecimalMatchProvider(): array
    {
        return [
            '1420.75 KWD' => [1420.75, 'kwd', 'فقط ألف وأربعة مائة وعشرون دينار وخمسة وسبعون فلس لا غير'],
            '987654.32 BHD' => [987654.32, 'bhd', 'فقط تسعة مائة وسبعة وثمانون ألف وستة مائة وأربعة وخمسون دينار واثنان وثلاثون فلس لا غير'],
            '456789 JOD' => [456789, 'jod', 'فقط أربعة مائة وستة وخمسون ألف وسبعة مائة وتسعة وثمانون دينار لا غير'],
        ];
    }

    /**
     * @testdox Grammaire: 0 → ريال (singulier) pas ريالاً
     */
    public function testZeroSarUsesMain1(): void
    {
        $this->assertSame('فقط صفر ريال لا غير', Tafqeet::inArabic(0, 'sar'));
    }
}

<?php

namespace Alkoumi\LaravelArabicTafqeet;

class Config
{
    /** @var array<string, array{main1:string, main2:string, single:string, multi:string}>|null */
    private static ?array $customCurrencies = null;

    /**
     * Return the full configuration array for Tafqeet.
     */
    public static function get(): array
    {
        $currencies = [
            'sar' => ['main1' => 'ريال', 'main2' => 'ريالاً', 'single' => 'هللة', 'multi' => 'هللات'],
            'egp' => ['main1' => 'جنيه', 'main2' => 'جنيهًا', 'single' => 'قرش', 'multi' => 'قروش'],
            'dzd' => ['main1' => 'دينار', 'main2' => 'دينارًا', 'single' => 'سنتيم', 'multi' => 'سنتيمات'],
            'aed' => ['main1' => 'درهم', 'main2' => 'درهمًا', 'single' => 'فلس', 'multi' => 'فلسات'],
            'kwd' => ['main1' => 'دينار', 'main2' => 'دينارًا', 'single' => 'فلس', 'multi' => 'فلسات'],
            'bhd' => ['main1' => 'دينار', 'main2' => 'دينارًا', 'single' => 'فلس', 'multi' => 'فلسات'],
            'iqd' => ['main1' => 'دينار', 'main2' => 'دينارًا', 'single' => 'فلس', 'multi' => 'فلسات'],
            'lbp' => ['main1' => 'ليرة', 'main2' => 'ليرة', 'single' => 'قرش', 'multi' => 'قروش'],
            'yer' => ['main1' => 'ريال', 'main2' => 'ريالًا', 'single' => 'فلس', 'multi' => 'فلسات'],
            'jod' => ['main1' => 'دينار', 'main2' => 'دينارًا', 'single' => 'قرش', 'multi' => 'قروش'],
            'usd' => ['main1' => 'دولار', 'main2' => 'دولاراً', 'single' => 'سنت', 'multi' => 'سنت'],
            'sdg' => ['main1' => 'قرش', 'main2' => 'قرشاً', 'single' => 'قرش', 'multi' => 'قروش'],
            'mad' => ['main1' => 'درهم', 'main2' => 'درهمًا', 'single' => 'سنتيم', 'multi' => 'سنتيمات'],
            'tnd' => ['main1' => 'دينار', 'main2' => 'دينارًا', 'single' => 'مليم', 'multi' => 'مليمات'],
            'qar' => ['main1' => 'ريال', 'main2' => 'ريالًا', 'single' => 'درهم', 'multi' => 'دراهم'],
            'omr' => ['main1' => 'ريال', 'main2' => 'ريالًا', 'single' => 'بيسة', 'multi' => 'بيسات'],
        ];

        if (self::$customCurrencies !== null) {
            $currencies = array_merge($currencies, self::$customCurrencies);
        }

        return [
            'connection_tool' => ' و',
            'default_currency' => 'sar',
            'starter' => 'فقط',
            'end' => 'لا غير',
            'currencies' => $currencies,
        ];
    }

    /**
     * Register a custom currency definition at runtime.
     *
     *   Config::addCurrency('try', 'ليرة', 'ليرة', 'قرش', 'قروش');
     *
     * Custom currencies are merged with the built-in list.
     *
     * @param string $code   Three-letter currency code.
     * @param string $main1  Singular/subject form (e.g. "ريال").
     * @param string $main2  Accusative/tanween form (e.g. "ريالاً").
     * @param string $single Singular subunit name (e.g. "هللة").
     * @param string $multi  Plural subunit name (e.g. "هللات").
     */
    public static function addCurrency(string $code, string $main1, string $main2, string $single, string $multi): void
    {
        if (self::$customCurrencies === null) {
            self::$customCurrencies = [];
        }

        self::$customCurrencies[$code] = [
            'main1' => $main1,
            'main2' => $main2,
            'single' => $single,
            'multi' => $multi,
        ];
    }

    /**
     * Get the list of supported currency codes.
     *
     * @return string[]
     */
    public static function supportedCurrencies(): array
    {
        return array_keys(self::get()['currencies']);
    }
}

<?php

namespace Alkoumi\LaravelArabicTafqeet;

class Config
{
    /**
     * Return the full configuration array for Tafqeet.
     *
     * This replaces the inline $config array previously defined on the
     * Tafqeet class.  The array is returned by a static method so that
     * consumers can override individual pieces without subclassing if
     * they ever need to (e.g. custom currencies).
     *
     * @return array
     */
    public static function get(): array
    {
        return [
            'connection_tool' => ' و',

            'default_currency' => 'sar',

            'starter' => 'فقط',

            'end' => 'لا غير',

            'currencies' => [
                'sar' => [
                    'main1' => 'ريال',
                    'main2' => 'ريالاً',
                    'single' => 'هللة',
                    'multi' => 'هللات',
                ],

                'egp' => [
                    'main1' => 'جنيه',
                    'main2' => 'جنيهًا',
                    'single' => 'قرش',
                    'multi' => 'قروش',
                ],

                'dzd' => [
                    'main1' => 'دينار',
                    'main2' => 'دينارًا',
                    'single' => 'سنتيم',
                    'multi' => 'سنتيمات',
                ],

                'aed' => [
                    'main1' => 'درهم',
                    'main2' => 'درهمًا',
                    'single' => 'فلس',
                    'multi' => 'فلسات',
                ],

                'kwd' => [
                    'main1' => 'دينار',
                    'main2' => 'دينارًا',
                    'single' => 'فلس',
                    'multi' => 'فلسات',
                ],

                'bhd' => [
                    'main1' => 'دينار',
                    'main2' => 'دينارًا',
                    'single' => 'فلس',
                    'multi' => 'فلسات',
                ],

                'iqd' => [
                    'main1' => 'دينار',
                    'main2' => 'دينارًا',
                    'single' => 'فلس',
                    'multi' => 'فلسات',
                ],
                'lbp' => [
                    'main1' => 'ليرة',
                    'main2' => 'ليرة',
                    'single' => 'قرش',
                    'multi' => 'قروش',
                ],
                'yer' => [
                    'main1' => 'ريال',
                    'main2' => 'ريالًا',
                    'single' => 'فلس',
                    'multi' => 'فلسات',
                ],

                'jod' => [
                    'main1' => 'دينار',
                    'main2' => 'دينارًا',
                    'single' => 'قرش',
                    'multi' => 'قروش',
                ],

                'usd' => [
                    'main1' => 'دولار',
                    'main2' => 'دولاراً',
                    'single' => 'سنت',
                    'multi' => 'سنت',
                ],
                'sdg' => [
                    'main1' => 'قرش',
                    'main2' => 'قرشاً',
                    'single' => 'قرش',
                    'multi' => 'قروش',
                ],
                'mad' => [
                    'main1' => 'درهم',
                    'main2' => 'درهمًا',
                    'single' => 'سنتيم',
                    'multi' => 'سنتيمات',
                ],
                'tnd' => [
                    'main1' => 'دينار',
                    'main2' => 'دينارًا',
                    'single' => 'مليم',
                    'multi' => 'مليمات',
                ],
                'qar' => [
                    'main1' => 'ريال',
                    'main2' => 'ريالًا',
                    'single' => 'درهم',
                    'multi' => 'دراهم',
                ],
                'omr' => [
                    'main1' => 'ريال',
                    'main2' => 'ريالًا',
                    'single' => 'بيسة',
                    'multi' => 'بيسات',
                ],
            ],
        ];
    }
}

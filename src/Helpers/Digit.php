<?php


namespace Alkoumi\LaravelArabicTafqeet\Helpers;


trait Digit
{
    /**
     * Special-case Arabic words used when numbers 1, 2, or 4 appear
     * in the tens position (e.g. "أحد عشر" → "احد عشر" in compound).
     */
    protected array $others = [
        2 => 'اثنا',
        1 => 'احد',
        4 => 'اربع',
    ];

    /** Arabic words for numbers 0-12. */
    protected array $ones = [
        0  => "صفر",
        1  => "واحد",
        2  => "اثنان",
        3  => "ثلاثة",
        4  => "أربعة",
        5  => "خمسة",
        6  => "ستة",
        7  => "سبعة",
        8  => "ثمانية",
        9  => "تسعة",
        10 => "عشرة",
        11 => "أحد عشر",
        12 => "اثنى عشر",
    ];

    /** Arabic tens (20, 30 … 90).  Index 1 = "عشر" is used for 10 in some contexts. */
    protected array $tens = [
        1 => "عشر",
        2 => "عشرون",
        3 => "ثلاثون",
        4 => "أربعون",
        5 => "خمسون",
        6 => "ستون",
        7 => "سبعون",
        8 => "ثمانون",
        9 => "تسعون",
    ];

    /** Arabic hundreds (100, 200 … 900). */
    protected array $hundreds = [
        0 => "صفر",
        1 => "مائة",
        2 => "مئتان",
        3 => "ثلاثمائة",
        4 => "أربعمائة",
        5 => "خمسمائة",
        6 => "ستمائة",
        7 => "سبعمائة",
        8 => "ثمانمائة",
        9 => "تسعمائة",
    ];

    /**
     * Arabic thousands with grammatical variants.
     *
     * Keys:
     *   1    —  "ألف"     (singular, بعد 1)
     *   2    —  "ألفان"   (dual, بعد 2)
     *   39   —  "آلاف"    (plural, بعد 3 إلى 9)
     *   1199 —  "ألفًا"   (accusative/tanween, بعد 11 إلى 99)
     *
     * The magic numbers 39 and 1199 are NOT real numeric values; they are
     * arbitrary keys chosen to represent grammatical contexts when the
     * preceding number is in the range [3,9] or [11,99] respectively.
     */
    protected array $thousands = [
        1    => "ألف",
        2    => "ألفان",
        39   => "آلاف",
        1199 => "ألفًا",
    ];

    /**
     * Arabic millions with grammatical variants.
     *
     * Keys follow the same convention as $thousands:
     *   1    — singular
     *   2    — dual
     *   39   — plural (3-9)
     *   1199 — accusative/tanween (11-99)
     */
    protected array $millions = [
        1    => "مليون",
        2    => "مليونان",
        39   => "ملايين",
        1199 => "مليونًا",
    ];

    /**
     * Arabic billions — currently unused by the calculator (reserved for
     * future 10-12 digit support).
     */
    protected array $billions = [
        1    => "مليار",
        2    => "ملياران",
        39   => "مليارات",
        1199 => "مليارًا",
    ];

    /**
     * Arabic trillions — currently unused (reserved for future 13-15 digit
     * support).
     */
    protected array $trillions = [
        1    => "تريليون",
        2    => "تريليونان",
        39   => "تريليونات",
        1199 => "تريليونًا",
    ];
}

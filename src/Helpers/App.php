<?php


namespace Alkoumi\LaravelArabicTafqeet\Helpers;


trait App
{
    private static ?\NumberFormatter $formatter = null;

    public function runBeforeComma(): string
    {
        $number = '';
        for ($i = 0; $i < count($this->before_comma_array); $i++) {
            $number .= $this->before_comma_array[$i];
        }

        if (self::$formatter === null) {
            self::$formatter = new \NumberFormatter("ar", \NumberFormatter::SPELLOUT);
        }

        return self::$formatter->format($number);
    }

    public function runAfterComma(): string
    {
        $class = self::detectClass($this->after_comma_len);
        $methodName = 'Class' . $class;
        if (method_exists($this, $methodName)) {
            return $this->$methodName($this->after_comma_array, $this->after_comma_len);
        }
        return 'عفوا هذا الرقم خارج نطاقنا حاليا حاول لاحقاً';
    }

    /**
     * Map a digit-group length (1-9) to the corresponding calculator
     * class letter (A-I).  The letter is simply the ASCII character
     * for 'A' + ($len - 1), but we keep an explicit map for clarity.
     *
     * @param int $len
     * @return string|null
     */
    protected static function detectClass(int $len): ?string
    {
        $map = [
            1 => 'A',
            2 => 'B',
            3 => 'C',
            4 => 'D',
            5 => 'E',
            6 => 'F',
            7 => 'G',
            8 => 'H',
            9 => 'I',
        ];

        return $map[$len] ?? null;
    }
}

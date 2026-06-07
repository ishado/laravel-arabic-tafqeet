<?php


namespace Alkoumi\LaravelArabicTafqeet\Helpers;


trait Validation
{
    public function initValidation(): self
    {
        if (is_numeric($this->parsed_number)) {
            return $this;
        }

        throw new \TypeError('The amount must be a numeric.');
    }
}

<?php

	namespace Alkoumi\LaravelArabicTafqeet;

	use Alkoumi\LaravelArabicTafqeet\Helpers\Calculators;
	use Alkoumi\LaravelArabicTafqeet\Helpers\Handler;
	use Alkoumi\LaravelArabicTafqeet\Helpers\Validation;
	use Alkoumi\LaravelArabicTafqeet\Helpers\App;

	class Tafqeet
	{
		use Calculators, Handler, Validation, App;

		public function __construct()
		{
			$this->config = Config::get();
		}

		protected array $config = [];

		/** Parsed number (the input converted to string). */
		protected string $after_comma_sum = '';

		/** Array of numbers after the split process. */
		private string $parsed_number;

		/** All number parts array. */
		private array $parsed_number_array = [];
		private int $all_numbers_len = 0;

		/** @var array|null Unused — kept for compatibility. */
		private $all_numbers_array;

		/** Before-comma digits array and its length. */
		private array $before_comma_array = [];
		private int $before_comma_len = 0;

		/** After-comma digits array and its length. */
		private array $after_comma_array = [];
		private int $after_comma_len = 0;

		/** Result strings for before and after comma. */
		protected string $result_before_comma = '';
		protected string $result_after_comma = '';

		private bool $is_main1_currency = true;

		/**
		 * Convert an amount to its Arabic textual representation.
		 *
		 * @param int|float $amount   The numeric amount.
		 * @param string    $currency Currency code (default 'sar').
		 * @return string   The Arabic tafqeet text.
		 */
		public static function inArabic(int|float $amount = 0, string $currency = 'sar'): string
		{
			return (new self)->setAmount($amount)->initValidation()->prepare()->run()->result($currency);
		}

		/**
		 * Assemble the final result string from internal state.
		 */
		public function result(string $currency = 'sar'): string
		{
			$result = $this->config['starter'] . ' ';

			if ($this->is_main1_currency) {
				$result .= $this->result_before_comma . ' ' . $this->config['currencies'][$currency]['main1'];
			} else {
				$result .= $this->result_before_comma . ' ' . $this->config['currencies'][$currency]['main2'];
			}

			if ($this->after_comma_len >= 1 && $this->after_comma_sum != '00') {
				if (in_array($this->after_comma_sum, [3, 4, 5, 6, 7, 8, 9, 10])) {
					$result .= $this->config['connection_tool'] . $this->result_after_comma . ' ' .
						$this->config['currencies'][$currency]['multi'];
				} else {
					$result .= $this->config['connection_tool'] . $this->result_after_comma . ' ' .
						$this->config['currencies'][$currency]['single'];
				}
			}

			$result .= ' ' . $this->config['end'];

			return str_replace('  ', ' ', $result);
		}

		public function run(): self
		{
			$this->result_before_comma = $this->runBeforeComma();
			$this->result_after_comma = $this->runAfterComma();

			return $this;
		}

		public function prepare(): self
		{
			$this->split_parsed_number_to_two_number_depend_on_comma()
				->split_numbers_before_comma_to_array()
				->split_numbers_after_comma_to_array();

			return $this;
		}
	}

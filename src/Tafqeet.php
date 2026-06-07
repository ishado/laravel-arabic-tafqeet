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

		protected string $after_comma_sum = '';

		private string $parsed_number;

		private array $parsed_number_array = [];
		private int $all_numbers_len = 0;

		private $all_numbers_array;

		private array $before_comma_array = [];
		private int $before_comma_len = 0;

		private array $after_comma_array = [];
		private int $after_comma_len = 0;

		protected string $result_before_comma = '';
		protected string $result_after_comma = '';

		private bool $is_main1_currency = true;

		// ─────────────────── Public API ───────────────────────────

		public static function inArabic(int|float $amount = 0, string $currency = 'sar'): string
		{
			return static::inArabicCurrency($amount, $currency);
		}

		public static function inArabicNumber(int|float $number = 0): string
		{
			return self::getFormatter()->format($number);
		}

		public static function inArabicCurrency(int|float $amount = 0, string $currency = 'sar'): string
		{
			return (new self)->setAmount($amount)->initValidation()->prepare()->run()->result($currency);
		}

		public static function inArabicFormatted(
			int|float $amount = 0,
			string $currency = 'sar',
			?string $starter = '{default}',
			?string $end = '{default}'
		): string {
			$instance = (new self)
				->setAmount($amount)
				->initValidation()
				->prepare()
				->run();

			return $instance->resultWithOptions($currency, $starter, $end);
		}

		// ─────────────────── Internal pipeline ────────────────────

		public function result(string $currency = 'sar'): string
		{
			return $this->buildResult(
				$currency,
				$this->config['starter'],
				$this->config['end']
			);
		}

		public function resultWithOptions(string $currency, ?string $starter, ?string $end): string
		{
			$s = $starter === '{default}' ? $this->config['starter'] : ($starter ?? '');
			$e = $end === '{default}' ? $this->config['end'] : ($end ?? '');

			return $this->buildResult($currency, $s, $e);
		}

		private function buildResult(string $currency, string $starter, string $end): string
		{
			$result = '';

			if ($starter !== '') {
				$result .= $starter . ' ';
			}

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

			if ($end !== '') {
				$result .= ' ' . $end;
			}

			return str_replace('  ', ' ', trim($result));
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

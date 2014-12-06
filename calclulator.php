<!--
	Steps:
		- return the string if the string contains only numbers
		- Search the string for a div/mult/mod operation
		- if one is found
			- Extract the operation and store
			- Evaluate the function
			- Replace initial string with evaluated number
			- Call the function with the updated string
		- if an addition or subtraction operation is found
			- Extract the operation and store
			- Evaluate the function
			- Replace initial string with evaluated number
			- Call the function with the updated string
-->

<?php
		class Calculator {
		public function __construct() {}

		public function calculate($string) {
			if (is_numeric($string)) { 
				echo $string; 
			} else {
				$this->checkFirstOperands($string);
			}
		}
		// --------

		private function checkFirstOperands($string) {
			preg_match("/\d+\s*(\%|\*|\/)\s*\d+/", $string, $match);

			switch($match[1]):
				case "/":
					preg_match_all("/\d+/", $match[0], $values);
					return $this->calculate(str_replace($match[0], $this->divide(intval($values[0][0]), intval($values[0][1])), $string));
					break;
				case "*":
					preg_match_all("/\d+/", $match[0], $values);
					return $this->calculate(str_replace($match[0], $this->mult(intval($values[0][0]), intval($values[0][1])), $string));
					break;
				case "%":
					preg_match_all("/\d+/", $match[0], $values);
					return $this->calculate(str_replace($match[0], $this->mod(intval($values[0][0]), intval($values[0][1])), $string));
					break;
				default:
					return $this->checkLastOperands($string);
			endswitch;
		}

		private function checkLastOperands($string) {
			preg_match("/\d+\s*(\+|\-)\s*\d+/", $string, $match);

			switch($match[1]):
				case "+":
					preg_match_all("/\d+/", $string, $values);
					return $this->calculate(str_replace($match[0], $this->add(intval($values[0][0]), intval($values[0][1])), $string));
					break;
				case "-":
					preg_match_all("/\d+/", $string, $values);
					return $this->calculate(str_replace($match[0], $this->subtract(intval($values[0][0]), intval($values[0][1])), $string));
					break;
				default:
					return false;
			endswitch;
		}

		private function add($val1, $val2) {
			return $val1 + $val2;
		}

		private function subtract($val1, $val2) {
			return $val1 - $val2;
		}

		private function mult($val1, $val2) {
			return $val1 * $val2;
		}

		private function divide($dividend, $divisor) {
			return $dividend / $divisor;
		}

		private function mod($val1, $val2) {
			return $val1 % $val2;
		}
	}

	// -------Test---------
	$calc = new Calculator();

	echo $calc->calculate("1 + 1") . '<br>'; // 2
	echo $calc->calculate("10 - 5") . '<br>'; // 5
	echo $calc->calculate("10 * 10") . '<br>'; // 100
	echo $calc->calculate("35 / 5") . '<br>'; // 7
	echo $calc->calculate("1 + 5 * 8") . '<br>'; // 41
	echo $calc->calculate("6 - 10 / 2 + 4 * 7") . '<br>'; // 29
	echo $calc->calculate("6 % 3 * 5"); //0
?>
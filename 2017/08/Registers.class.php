<?php

class Registers
{
	private $registers;

	private $largestEver;

	public function __construct()
	{
		$registers = [];
	}

	public function processInstruction($instruction)
	{
		$instruction = trim($instruction);

		list($instruction, $condition) = explode(' if ', $instruction);

		if ($this->checkCondition($condition)) {
			$this->applyInstruction($instruction);

			$largest = $this->getLargest();
			if ($largest['value'] > $this->largestEver['value']) {
				$this->largestEver = $largest;
			}
		}
	}

	public function getRegisterValue($register)
	{
		if ( ! isset($this->registers[$register])) {
			$this->registers[$register] = 0;
		}

		return $this->registers[$register];
	}

	public function getLargest()
	{
		$max = [
			'register'	=>	'',
			'value'		=>	0,
		];

		foreach ($this->registers as $register => $value) {
			if ($value > $max['value']) {
				$max['register'] = $register;
				$max['value'] = $value;
			}
		}

		return $max;
	}

	public function getLargestEver()
	{
		return $this->largestEver;
	}

	private function checkCondition($condition)
	{
		list($register, $condition, $value) = explode(' ', $condition);

		$registerValue = $this->getRegisterValue($register);
		$value = intval($value);

		if ($condition == '<') {
			if ($registerValue < $value) {
				return true;
			}
		} elseif ($condition == '>') {
			if ($registerValue > $value) {
				return true;
			}
		} elseif ($condition == '<=') {
			if ($registerValue <= $value) {
				return true;
			}
		} elseif ($condition == '>=') {
			if ($registerValue >= $value) {
				return true;
			}
		} elseif ($condition == '==') {
			if ($registerValue == $value) {
				return true;
			}
		} elseif ($condition == '!=') {
			if ($registerValue != $value) {
				return true;
			}
		}

		return false;
	}

	private function applyInstruction($instruction)
	{
		list($register, $type, $value) = explode(' ', $instruction);

		$value = intval($value);

		$registerValue = $this->getRegisterValue($register);

		if ($type == 'inc') {
			$this->registers[$register] = $registerValue + $value;
		} elseif ($type == 'dec') {
			$this->registers[$register] = $registerValue - $value;
		}
	}
}
<?php

namespace basics;

/**
 * Basics Class and implement the BasicsInterface and following methods:
 * getMinuteQuarter(), isLeapYear(), isSumEqual()
 * See details below.
 */
class Basics implements BasicsInterface
{
    // BasicInterface(var Validator){
    /**
     * @var mixed validator - private value for storing validator object of class ValidatorInterface,
     * whitch used by all functions to validate input parameter values for throwing InvalidArgumentException
     * when the parameter values are out of accepted bounds
     */
    private mixed $validator;
    /**
     * Constructor of the class that initialises private $validator variable acepts obgect of BasicsValidator class
     *
     * @param BasicsValidatorInterface validator object of BasicsValidator class
     *
     * @return void
     */
    public function __construct(BasicsValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * getMinuteQuarter returns the quarter of a hour according to parameter $minute given
     *
     * @param  int minute is an integer value with a value between 00 an 59
     * when it does't, function
     * @throws InvalidArgumentException if $minute is negative of greater then 60.
     *
     * @return string  one of the values: "first", "second", "third" and "fourth".
     * when it
     */
    public function getMinuteQuarter(int $minute): string
    {
        $this->validator->isMinutesException($minute);
        if ($minute == 0) {
            return ('fourth');
        } elseif ($minute <= 15) {
            return ('first');
        } elseif ($minute <= 30) {
            return ('second');
        } elseif ($minute <= 45) {
            return ('third');
        } elseif ($minute <= 59) {
            return ('fourth');
        }
    }

    /**
     * isLeapYear calculates if the given year is leap (has 366 days) or not
     *
     * @param int year - year to calculate
     *
     * @return bool returns true when the given year is leap
     */
    public function isLeapYear(int $year): bool
    {
        $this->validator->isYearException($year);
        if ($year % 4 != 0) {
            return false;
        } elseif ($year % 100 != 0) {
            return true;
        } elseif ($year % 400 != 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * isSumEqual compares sum of leading and of tailing digits of the string and returns true when sum is equal
     *
     * @param string input - input string with 6 digits to compare
     *
     * @return bool true when left sum of digits EQUALS to the right sum
     */
    public function isSumEqual(string $input): bool
    {
            $this->validator->isValidStringException($input);
        if ((int)$input[0] + (int)$input[1] + (int)$input[2] === (int)substr($input, 3, 1) + (int)substr($input, 4, 1) + (int)substr($input, 5, 1)) {
            return true;
        } else {
            return false;
        }
    }
}

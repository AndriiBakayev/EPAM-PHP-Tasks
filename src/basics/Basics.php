<?php
/**
 * Php version 8.1.9
 * 
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */
namespace basics;

/**
 * Basics Class and implement the BasicsInterface and following methods:
 * getMinuteQuarter(), isLeapYear(), isSumEqual()
 * See details below.
 * 
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */
class Basics implements BasicsInterface
{
    /**
     * Stores validator object 
     *
     * @var BasicsValidatorInterface validator - private value for storing 
     * validator object  of class ValidatorInterface, whitch used by all 
     * functions to validate input parameter values for throwing 
     * InvalidArgumentExceptionwhen the parameter values are out 
     * of accepted bounds
     */
    private BasicsValidatorInterface $_Validator;

    /**
     * Constructor of the class that initialises private $validator variable
     * acepts obgect of BasicsValidator class
     *
     * @param BasicsValidatorInterface $validator object of BasicsValidator class
     *
     * @return void
     */
    public function __construct(BasicsValidatorInterface $validator)
    {
        $this->_Validator = $validator;
    }

    /**
     * GetMinuteQuarter returns the quarter of a hour according to parameter 
     * $minute given
     *
     * @param int $minute is an integer value with a value between 00 an 59
     *                    when it does, function returns:
     * 
     * @return string  one of the values: "first", "second", "third" and "fourth".
     * when it, else it:
     *
     * @throws InvalidArgumentException if $minute is negative of greater then 59.
     */
    public function getMinuteQuarter(int $minute): string
    {
        $this->_Validator->isMinutesException($minute);
        if ($minute === 0) {
            return 'fourth';
        } elseif ($minute <= 15) {
            return 'first';
        } elseif ($minute <= 30) {
            return 'second';
        } elseif ($minute <= 45) {
            return 'third';
        } elseif ($minute <= 59) {
            return 'fourth';
        }
    }

    /**
     * IsLeapYear calculates if the given year is leap (has 366 days) or not
     *
     * @param int $year - year to calculate
     *
     * @return bool returns true when the given year is leap
     */
    public function isLeapYear(int $year): bool
    {
        $this->_Validator->isYearException($year);
        
        return $year % 4 !== 0 ? false 
            : ($year % 100 !== 0 ? true 
                : ($year % 400 !== 0 ? false : true));
    }

    /**
     * IsSumEqual compares sum of leading and of tailing digits 
     * of the string and returns true when sum is equal
     *
     * @param string $input - input string with 6 digits to compare
     *
     * @return bool true when left sum of digits EQUALS to the right sum
     */
    public function isSumEqual(string $input): bool
    {
        $this->_Validator->isValidStringException($input);
        
        return $input[0] + $input[1] + $input[2] === $input[3] + $input[4] + $input[5];
    }
}

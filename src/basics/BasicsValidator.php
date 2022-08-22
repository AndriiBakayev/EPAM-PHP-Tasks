<?php

/**
 * Creates the BasicsValidator Class and implements the BasicsValidatorInterface
 * and following methods:
 * isMinutesException(), isYearException(), isValidStringException()
 * See details below.
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
 * BasicsValidator class validates ingoing parameter of functions
 * and throws an exception when they are out of bonds
 *
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */
class BasicsValidator implements BasicsValidatorInterface
{
    /**
     * Implements the check functionality described in the method
     * getMinuteQuarter (BasicsInterface Class) which throws Exception.
     *
     * @param int $minute Must be  int in range 0-59 ,
     *                    otherwise Exception \InvalidArgumentException throwed
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function isMinutesException(int $minute): void
    {
        if (!is_int($minute) || $minute < 0 || $minute > 59) {
            throw new \InvalidArgumentException(
                'getMinuteQuarter function only accepts integers in range 0-59. Input was: '
                . $minute
            );
        }
    }

    /**
     * Implement the check functionality described in the method
     *  getMinuteQuarter (BasicsInterface Class) which throws Exception.
     *
     * @param int $year Must be  int in range 1900-9000, else
     *                  Exception \InvalidArgumentException throwed
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function isYearException(int $year): void
    {
        if (!is_int($year) || $year < 1900 || $year > 9999) {
            throw new \InvalidArgumentException(
                'isLeapYear function only accepts integers in range 1900-9999. Input was: '
                . $year
            );
        }
    }

    /**
     * Implement the check functionality described
     * in the method getMinuteQuarter (BasicsInterface Class) which throws Exception.
     *
     * @param string $input Must be a string of 6 digits ,
     *                      else Exception \InvalidArgumentException throwed
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function isValidStringException(string $input): void
    {
        if (!is_string($input) || strlen($input) !== 6 || preg_match('/d6/', $input)) {
            throw new \InvalidArgumentException(
                'isSumEqual() function only accepts strings with numbers strlen()=6. Input was: '
                . $input
            );
        }
    }
}

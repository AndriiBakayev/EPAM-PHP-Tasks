<?php

/**
 * Create the BasicsValidator Class and implement the BasicsValidatorInterface and following methods:
 * isMinutesException(), isYearException(), isValidStringException()
 * See details below.
 */

namespace basics;

class BasicsValidator implements BasicsValidatorInterface
{
    public static function throwException(Throwable $exception): ExceptionStub
    {
        return new ExceptionStub($exception);
    }

    /**
     * Implement the check functionality described in the method getMinuteQuarter (BasicsInterface Class) which throws Exception.
     *
     * Make sure the next PHPDoc instructions will be added:
     * @param int $minute
     * @throws \InvalidArgumentException
     */
    public function isMinutesException(int $minute): void
    {
        if (!is_int($minute) || $minute < 0 || $minute > 59) {
            throw new \InvalidArgumentException('getMinuteQuarter function only accepts integers in range 0-59. Input was: ' . $minute);
        }
    }

    /**
     * Implement the check functionality described in the method getMinuteQuarter (BasicsInterface Class) which throws Exception.
     *
     * Make sure the next PHPDoc instructions will be added:
     * @param int $year
     * @throws \InvalidArgumentException
     */
    public function isYearException(int $year): void
    {
        if (!is_int($year) || $year < 1900 || $year > 9999) {
            throw new \InvalidArgumentException('isLeapYear function only accepts integers in range 1900-9999. Input was: ' . $year);
        }
    }

    /**
     * Implement the check functionality described in the method getMinuteQuarter (BasicsInterface Class) which throws Exception.
     *
     * Make sure the next PHPDoc instructions will be added:
     * @param string $input
     * @throws \InvalidArgumentException
     */
    public function isValidStringException(string $input): void
    {
        if (!is_string($input) || strlen($input) != 6 || preg_match('/d6/', $input)) {
            throw new \InvalidArgumentException('isSumEqual function only accepts strings with numbers strlen()=6. Input was: ' . $input);
        }
    }
}

<?php

namespace basics;

class Basics implements BasicsInterface
{
    private $validator;

    public function __construct(BasicsValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * getMinuteQuarter
     *
     * @param int minute of hour
     *
     * @return string
     */
    public function getMinuteQuarter(int $minute): string
    {
            echo("Hello $minute \n");
            $this->validator->isMinutesException($minute);
        if ($minute <= 0) {
            return ('fourth');
        } elseif ($minute <= 15) {
            return ('first');
        } elseif ($minute <= 30) {
            return ('second');
        } elseif ($minute <= 45) {
            return ('third');
        } elseif ($minute <= 60) {
            return ('fourth');
        }
    }

    public function isLeapYear(int $year): bool
    {
        $this->validator->isYearException($year);
        if ($year % 4 != 0) {
            return (false);
        } elseif ($year % 100 != 0) {
            return (true);
        } elseif ($year % 400 != 0) {
            return (false);
        } else {
            return (true);
        }
    }

    public function isSumEqual(string $input): bool
    {
        $this->validator->isValidStringException($input);
        if ((int)substr($input, 0, 1) + (int)substr($input, 1, 1) + (int)substr($input, 2, 1) == (int)substr($input, 3, 1) + (int)substr($input, 4, 1) + (int)substr($input, 5, 1)) {
            return (true);
        } else {
            return (false);
        }
    }
}

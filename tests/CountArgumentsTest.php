<?php

/** Tests CountArguments() using PHP Unit
 * Php version 8.1.9
 *
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 *
 */

use PHPUnit\Framework\TestCase;

/**
 * CountArgumentsTest The class whitch runs functions/Functions.php/CountArguments
 * and tests it's behavior
 *
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */
class CountArgumentsTest extends TestCase
{
    /**
     * Stores object of instanted class
     */
    protected $functions;

    /**
     * Makes an instance of a class and prepares for test
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->functions = new functions\Functions();
    }

    /**
     * Using data provider which provides ingoing parameter
     * values tests assets of identity of outgoing result
     *
     * @param $input    input test input parameters
     * @param $expected expcted returned value
     *
     * @return void
     *
     * @dataProvider positiveDataProvider
     */
    public function testCountArgumentsTest($input, $expected)
    {
        $this->assertSame(
            $expected,
            $this->functions->CountArguments(...$input),
            "functions/Functions.php/CountArguments does not compute well "
        );
    }

    /**
     * PositiveDataProvider
     *
     * @return array provides pairs of ingoing / outgoing arrays fot tests
     */
    public function positiveDataProvider(): array
    {
        return [
            [[1, 2, 3], ['argument_count' => 3, 'argument_values' => [1, 2, 3]]],
            [[1], ['argument_count' => 1, 'argument_values' => [1]]],
            [[0], ['argument_count' => 1, 'argument_values' => [0]]],
            [[], ['argument_count' => 0, 'argument_values' => []]],
            [["HELLo"], ['argument_count' => 1, 'argument_values' => ["HELLo"]]],
            [[-1.5, false, true, "Hi"], [
                                        'argument_count' => 4 ,
                                        'argument_values' => [-1.5, false, true, "Hi"]
                                     ]],
        ];
    }
}

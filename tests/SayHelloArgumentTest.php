<?php

/** * CountArgumentsTest The class whitch runs functions/Functions.php/sayHelloArgument
 * and tests it's behavior
 * Php version 8.1.9
 *
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */

use PHPUnit\Framework\TestCase;

/**
 * SayHelloTest tests that function functions/Functions.php/SayHelloArgument
 * realy says \"Hello\"
 *
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */
class SayHelloArgumentTest extends TestCase
{
    /**
     * Stores object of instanted class
     */
    protected $functions;

    /**
     * SetUp() Makes an instance of a class
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->functions = new functions\Functions();
    }

    /**
     * Makes positive tests assertions using dataprovider
     *
     * @param $input    input test input parameters
     * @param $expected expcted returned value
     *
     * @dataProvider positiveDataProvider
     *
     * @return void
     */
    public function testSayHelloArgument($input, $expected)
    {
        $this->assertSame(
            $expected,
            $this->functions->sayHelloArgument($input),
            "functions/Functions.php/SayHelloArgument($input)"
            . "does not say 'Hello $input'"
        );
    }

    /**
     * PositiveDataProvider provides pairs of ingoing / outgoing
     * arrays for positive tests
     *
     * @return array pairs of ingoing / outgoing arrays for
     * positive tests
     */
    public function positiveDataProvider(): array
    {
        return [
            ['hello', 'Hello hello'],
            ['World', 'Hello World'],
            ['string', 'Hello string'],
            [10, 'Hello 10'],
            [0, 'Hello 0'],
            [-1, 'Hello -1'],
            [-1.5, 'Hello -1.5'], //float
            [true, 'Hello 1'],
            [false, 'Hello '],
            [null, 'Hello '], //Null test
        ];
    }
}

<?php

/** Tests CountArguments() using PHP Unit
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
 * CountArgumentsTest The class whitch runs
 * functions/Functions.php/CountArgumentsWrapper and tests it's behavior
 *
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */
class CountArgumentsWrapperTest extends TestCase
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
     * TearDown - Destroys instanted class objects
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->functions);
    }

    /**
     * Makes test runs of tested functions and controls it's exception
     *
     * @param $input takes test value from dataprovider? array of function's params
     *
     * @return void
     *
     * @dataProvider negativeDataProvider
     */
    public function testCountArgumentsWrapperArrayOfdifferentTypes($input)
    {
        try {
            $this->functions->CountArgumentsWrapper(...$input);
            $this->fail('An expected exception not thrown');
        } catch (InvalidArgumentException $exception) {
            $this->assertStringContainsString(
                'function accepts strings only',
                $exception->getMessage()
            );
        }
    }

    /**
     * NegativeDataProvider provides pairs of ingoing / outgoing arrays
     * for negative tests for exceptions throwing
     *
     * @return array
     */
    public function negativeDataProvider(): array
    {
        return [
            [['1','2',3,'4','5']],
            [[1]],
            [['string',['array_of_strings',"end"]]],
            [[false]],
            [[null]],
            [[[1,2,3,4,5,"Hello"]]],
            [[-1.5,false,true,"Hi"]],
        ];
    }

    /**
     * Makes positive tests assertions using dataprovider
     *
     * @param $input    input test input parameters
     * @param $expected expcted returned value
     *
     * @return void
     *
     * @dataProvider positiveDataProvider
     */
    public function testCountArgumentsWrapper($input, $expected)
    {
        $this->assertSame(
            $expected,
            $this->functions->CountArgumentsWrapper(...$input),
            'functions/Functions.php/CountArgumentsWrapper does not compute well '
        );
    }

    /**
     * PositiveDataProvider
     *
     * @return array provides pairs of ingoing / outgoing arrays fot positive tests
     */
    public function positiveDataProvider(): array
    {
        return [
            [['1','2','3'], ['argument_count' => 3 , 'argument_values' => ['1','2','3']]],
            [['1'],   ['argument_count' => 1 , 'argument_values' => ['1']]],
            [['0'],   ['argument_count' => 1 , 'argument_values' => ['0']]],
            [[''],   ['argument_count' => 1 , 'argument_values' => ['']]],
            [[],   ['argument_count' => 0 , 'argument_values' => []]],
            [["HELLo"],   ['argument_count' => 1 , 'argument_values' => ["HELLo"]]],
            [["Hello World"],   ['argument_count' => 1 , 'argument_values' => ["Hello World"]]],
        ];
    }
}

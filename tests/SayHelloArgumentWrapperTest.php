<?php

/**
 * SayHelloTest tests that function
 * functions/Functions.php/sayHelloArgumentWrapper
 * realy says \"Hello\"
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
 * SayHelloTest tests that function
 * functions/Functions.php/sayHelloArgumentWrapper
 * realy says \"Hello\"
 *
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */
class SayHelloArgumentWrapperTest extends TestCase
{
    /**
     * Stores object of instanted class
     *
     * @category No_Category
     * @package  No_Package
     * @author   Andrey Bakayev <andreybakayev@gmail.com>
     * @license  https://github.com/AndriiBakayev free
     * @link     https://github.com/AndriiBakayev
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
     * Makes negative tests assertions of throwing exceptions using data provider
     *
     * @return void returns void
     */
    public function testHelloArgumentWrapperNegative(): void
    {
        try {
            $this->functions->sayHelloArgumentWrapper([1,2,3,4,5]);
            $this->fail('An expected exception not thrown');
        } catch (InvalidArgumentException $exception) {
            $this->assertStringContainsString(
                'function accepts only scalar',
                $exception->getMessage()
            );
        }
    }
    /**
     * Tests an identity of sayHelloArgumentWrapper inbond/outbond parameters
     *
     * @param $input    input test input parameters
     * @param $expected expcted value
     *
     * @return void returns void
     *
     * @dataProvider positiveDataProvider
     */
    public function testSayHelloArgumentWrapper($input, $expected): void
    {
        $this->assertSame(
            $expected,
            $this->functions->sayHelloArgumentWrapper($input),
            "functions/Functions.php/sayHelloArgumentWrapper($input)"
            . " does not say 'Hello $input'"
        );
    }
    /**
     * Data provider for testing identity returns pairs of inbond/outbond values
     * positiveDataProvider
     *
     * @return array pairs of ingoing / outgoing arrays for
     * positive tests
     */
    public function positiveDataProvider(): array
    {
        return [
            [true, 'Hello 1'],
            [false, 'Hello '],
            [null, 'Hello '], //Null test
        ];
    }
}

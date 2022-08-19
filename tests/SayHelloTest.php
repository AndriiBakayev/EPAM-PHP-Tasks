<?php

/** * CountArgumentsTest The class whitch runs
 * functions/Functions.php/sayHello
 * and tests it's behavior
 * Php version 8.1.9
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */

use PHPUnit\Framework\TestCase;

/**
 * SayHelloTest tests that function functions/Functions.php/SayHello
 * realy says \"Hello\"
 *
 * @category No_Category
 * @package  No_Package
 * @author   Andrey Bakayev <andreybakayev@gmail.com>
 * @license  https://github.com/AndriiBakayev free
 * @link     https://github.com/AndriiBakayev
 */
class SayHelloTest extends TestCase
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
     * TestSayHello asserts that output of function is really "Hello"
     *
     * @return void
     */
    public function testSayHello()
    {
        $this->assertSame(
            "Hello",
            $this->functions->sayHello(),
            "functions/Functions.php/SayHello does not say \"Hello\""
        );
    }
}

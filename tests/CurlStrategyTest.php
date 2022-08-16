<?php

use PHPUnit\Framework\TestCase;

class CurlStrategyTest extends TestCase
{
    protected $ti;

    protected function setUp(): void
    {
        $this->$ti = new src\oop\app\src\Transporters\CurlStrategy();
        echo ("Hello________________________________________");
    }

    public function testPositive()
    {
        echo ("Hello________________________________________");
        $this->assertEquals("H", "H");
         var_dump($this->$ti->getContent('https://filmix.ac/filmi/triller/151413-lost-ledyanoy-drayv-2021.html'));
    }
}
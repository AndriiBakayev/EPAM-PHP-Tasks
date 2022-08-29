<?php

use PHPUnit\Framework\TestCase;

class GetUniqueFirstLettersTest extends TestCase
{
    //protected $arrays;

    protected function setUp(): void
    {
         require_once __DIR__ . '\..\src\web\functions.php';
    }

    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, getUniqueFirstLetters($input));
    }

    public function positiveDataProvider(): array
    {
        return [
            [[
                ['name' => 'Peter'],
                ['name' => 'Pene'],
                ['name' => 'pink'],
            ],['P']], //Same letters join
            [[
                ['name' => 'Q'], //Q
                ['name' => 'qr'],//Q
                ['name' => 'aw'],//A
                ['name' => 'B'], //B
                ['name' => 'n'], //N
                ['name' => 'n'], //n
                ['name' => 'k'], //k
                ['name' => 'K'], //K
            ], ['A','B','K','N','Q']], //Many different leters join
            [[
                ['nAme' => 'nAme'], //-
                ['lame' => 'lame'], //-
                ['dame' => 'dame'], //-
                [' name' => 'space'], //-
                ['name' => 'name'], //N
                ['fame' => 'fame','name' => 'Aname'] //A
            ], ['A','N']], // irregular tag names
            [[], []], //- Empty array
            [[
                [], //-
                ['name' => 'Hello'], //H
            ],['H']], //Empty tagset+normal
            [[
                ['name' => ''], //-
                ['name' => 'Hello'], //H
            ], ['H']], //Empty tag value
        ];
    }
}

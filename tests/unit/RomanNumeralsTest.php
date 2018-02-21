<?php

declare(strict_types=1);

namespace Mbna\Tests\Unit;

use Mbna\Exception\AbsentRomanNumeral;
use Mbna\Exception\InvalidInteger;
use Mbna\Exception\InvalidRomanNumeral;
use Mbna\RomanNumerals;
use PHPUnit\Framework\TestCase;

class RomanNumeralsTest extends TestCase
{

    /**
     * The RomanNumerals object under test.
     *
     * @var RomanNumerals
     */
    private $subject;

    /**
     * Valid Roman Numeral characters.
     */
    const validNumerals = ['I', 'V', 'X', 'L', 'C', 'D', 'M'];

    protected function setUp() : void
    {
        $this->subject = new RomanNumerals;
    }

    protected function tearDown() : void
    {
        $this->subject = null;
    }

    public function testType() : void
    {
        $this->assertInstanceOf(
            RomanNumerals::class,
            new RomanNumerals
        );
    }

    /*public function testGenerate() : void
    {
        $this->assertEquals(
            'X',
            (new RomanNumerals())->generate(10)
        );
    }

    public function testParse() : void
    {
        $this->assertEquals(
            '10',
            (new RomanNumerals())->parse('X')
        );
    }*/

    public function dataProvider()
    {
        return [
            [1, 'I'],
            [2, 'II'],
            [3, 'III'],
            [4, 'IV'],
            [5, 'V'],
            [6, 'VI'],
            [7, 'VII'],
            [8, 'VIII'],
            [9, 'IX'],
            [10, 'X'],
            [3999, 'MMMCMXCIX'],
            // my own
            [1234, 'MCCXXXIV'],
            [4000, 'MMMM'],
            [0, ''],
            [-1, ''],
            [0, 'ABCDEFG'],
            [3214, 'MMMCCXIV'],
            [3998, 'MMMCMXCVIII'],
            [2000, 'MM'],
            [2018, 'MMXVIII'],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGenerateFromProvided($given, $expected)
    {
        // if the integer is larger than 3999 or less than 1 then expect an exception to be thrown
        if ($given >= 4000 || $given <= 0)
            $this->expectException(InvalidInteger::class);

        // test
        $result = $this->subject->generate($given);

        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testParseFromProvided($expected, $given)
    {
        // if the string is empty then expect it to be rejected as an invalid Roman Numeral
        if ($given == '')
            $this->expectException(AbsentRomanNumeral::class);

        // count the the characters in $given, which are in the array of valid numerals
        $numberOfValidCharacters = count(
            array_intersect(str_split($given), self::validNumerals)
        );

        // if the number of valid characters is less than the length of the string then it has to have an invalid roman numeral
        if ($numberOfValidCharacters < strlen($given))
            $this->expectException(InvalidRomanNumeral::class);

        // test
        $result = $this->subject->parse($given);

        $this->assertEquals($expected, $result);
    }

}

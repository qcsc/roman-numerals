<?php

declare(strict_types=1);

namespace Mbna;

use Mbna\Contract\RomanNumerals as RomanNumeralsContract;
use Mbna\Exception\AbsentRomanNumeral;
use Mbna\Exception\InvalidInteger;
use Mbna\Exception\InvalidRomanNumeral;

class RomanNumerals implements RomanNumeralsContract
{

    const numerals = [
        'I' => 1,
        'IV' => 4,
        'V' => 5,
        'IX' => 9,
        'X' => 10,
        'XL' => 40,
        'L' => 50,
        'XC' => 90,
        'C' => 100,
        'CD' => 400,
        'D' => 500,
        'CM' => 900,
        'M' => 1000,
    ];

    /**
     * Converts from integer to numeral.
     *
     * @param int $integer
     * @return string
     * @throws \Exception
     */
    public function generate(int $integer): string
    {
        if ($integer >= 4000)
            throw new InvalidInteger('Integer should be less than 4000.');

        if ($integer <= 0)
            throw new InvalidInteger('Integer should be greater than 0.');

        $response = '';

        $remaining = $integer;

        // reverse the numerals and therefore the integers as we need to skip any larger values which the provided integer does not go into
        foreach (array_reverse($this::numerals) as $romanNumeral => $integerRepresentation)
        {
            // how many times does this particular integer go into what's left of the original integer
            $numberFound = intval($remaining / $integerRepresentation);

            // we now know we can take as many of this particular numeral
            $response .= str_repeat($romanNumeral, $numberFound);

            // set the remaining value of the integer required
            $remaining = $remaining % $integerRepresentation;
        }

        return $response;
    }

    /**
     * Converts from numeral to integer.
     *
     * @param string $numeral
     * @return int
     * @throws \Exception
     */
    public function parse(string $numeral): int
    {
        if ($numeral === '')
            throw new AbsentRomanNumeral('No numeral was provided.');

        $response = 0;

        $lengthOfNumeral = strlen($numeral);

        // iterate the string
        for ($position = 0; $position < $lengthOfNumeral; $position++)
        {
            // start by checking a couple of characters since we can have two character roman numerals
            $currentCharacter = substr($numeral, $position, 2);

            foreach (array_reverse(self::numerals) as $romanNumeral => $integerRepresentation)
            {
                if ($currentCharacter == $romanNumeral)
                {
                    // great, we found a match so increment the response
                    $response += $integerRepresentation;
                    $position++; // increment by two on this occasion due to having matched a couple of characters
                    continue 2;
                }
            }

            // well, we failed to find any matches on a couple of characters so revert to one character instead
            $currentCharacter = substr($numeral, $position, 1);

            foreach (array_reverse(self::numerals) as $romanNumeral => $integerRepresentation)
            {
                if ($currentCharacter == $romanNumeral)
                {
                    // this one matched so we just increment the response here
                    $response += $integerRepresentation;

                    // we're skipping this foreach and the parent foreach as we've a) got a match and b) need to move along the string
                    continue 2;
                }
            }

            // if we got here then a roman numeral couldn't be found in our list
            throw new InvalidRomanNumeral(sprintf('Roman numeral \'%s\' could not be found.', $currentCharacter));
        }

        return $response;
    }
}
<?php

declare(strict_types=1);

namespace Mbna\Contract;

interface RomanNumerals
{

    /**
     * Converts from integer to numeral.
     *
     * @param int $integer
     * @return string
     */
    public function generate(int $integer) : string;

    /**
     * Converts from numeral to integer.
     *
     * @param string $numeral
     * @return int
     */
    public function parse(string $numeral) : int;

}
# MBNA Application
Geraint Lomas, 21/02/2018

## Approach

- Some knowledge of Roman Numeral generation already having posed this as a test myself.
- Understand integer division; remainder finding etc until all the value has been represented by a Roman Numeral.
- Used http://www.hashbangcode.com/blog/php-function-turn-integer-roman-numerals as a reminder.
- Haven't really done the reverse (i.e. find integer value) so create something that iterates the numeral from start to end.
- Use php.net/<method_name>.

#### Key steps

- Stub project (`composer init`)
- Import dependencies (`phpunit/phpunit`)
- Import given contract
- Stub implementing class
- Write tests
- Write business logic
- Refine and test; repeat.

### PHP

- Show ability to realise contracts and generate tests based upon the same a la TDD.
- Demo ability to use PHP methods; exceptions; control structures.
- Use v7.1; strict types (also void methods in 7.1).
- Create `Mbna` namespace; dependency injection etc.
- Write unit tests to develop against.

### Dependencies Management

- Use Composer
- Use PSR-4
- Import PHPUnit via console commands etc.

## Assumptions

- Only develop around the given contract, and surrounding context (tests, exceptions, realising class).
- Use provided test data and moderately expand upon it myself - try invalid data.
- With more time could run many more tests in a data provider.
- Front-end not required but attempt to demo, albeit without much security due to time constraints.

## Implementation

- Used existing Debian 9 running PHP 7.1.13 for speed (alternatively, could use Docker)

- Create directory on host.

- Run `git init` etc.

- Run `composer init` to stub-out the composer file, then add some bits:

```
...
"autoload": {
        "psr-4": {
            "Mbna\\": "src/Mbna/",
            "Mbna\\Tests\\": "src/tests/"
        }
    }
...
```

- Acquire PHPUnit:

```
$ composer require php ^7.1
$ composer require --dev phpunit/phpunit
$ vendor/bin/phpunit --version
PHPUnit 7.1-gfafd3c555 by Sebastian Bergmann and contributors.
```


- Add the `Mbna\Contract\RomanNumerals` contract:

```
<?php

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
```

- Stub class `Mbna\RomanNumerals`, implementing `Mbna\Contracts\RomanNumberals`. Import contract with 'Contract' suffix and allow PHPStorm to generate the required method stubs.

- Stub-out or right-click `Mbna\RomanNumberals` and generate PHPUnit test in `Mbna\Tests\Unit` located in `tests/unit` as defined by the PSR-4 configuration.

- Check PHPUnit is picking it up:

```
$ vendor/bin/phpunit --bootstrap vendor/autoload.php tests
PHPUnit 7.1-gfafd3c555 by Sebastian Bergmann and contributors.

W                                                                   1 / 1 (100%)

Time: 97 ms, Memory: 4.00MB

There was 1 warning:

1) Warning
No tests found in class "Mbna\Tests\Unit\RomanNumeralsTest".

WARNINGS!
Tests: 1, Assertions: 0, Warnings: 1.
```

- Write test void methods based on provided contract.

```
vendor/bin/phpunit --bootstrap vendor/autoload.php tests
PHPUnit 7.1-gfafd3c555 by Sebastian Bergmann and contributors.

RR                                                                  2 / 2 (100%)

Time: 105 ms, Memory: 4.00MB

There were 2 risky tests:

1) Mbna\Tests\Unit\RomanNumeralsTest::testGenerate
This test did not perform any assertions

2) Mbna\Tests\Unit\RomanNumeralsTest::testParse
This test did not perform any assertions

OK, but incomplete, skipped, or risky tests!
Tests: 2, Assertions: 0, Risky: 2.
```

- Stub out basic tests to begin with:

```
public function testType() : void
    {
        $this->assertInstanceOf(
            RomanNumerals::class,
            new RomanNumerals
        );
    }

    public function testGenerate() : void
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
    }
```

- Check we're getting some fails related to return types:

```
vendor/bin/phpunit --bootstrap vendor/autoload.php tests
PHPUnit 7.1-gfafd3c555 by Sebastian Bergmann and contributors.

.EE                                                                 3 / 3 (100%)

Time: 109 ms, Memory: 4.00MB

There were 2 errors:

1) Mbna\Tests\Unit\RomanNumeralsTest::testGenerate
TypeError: Return value of Mbna\RomanNumerals::generate() must be of the type string, none returned

/var/www/dev/Prospective/Mbna/src/Mbna/RomanNumerals.php:21
/var/www/dev/Prospective/Mbna/tests/unit/RomanNumeralsTest.php:25

2) Mbna\Tests\Unit\RomanNumeralsTest::testParse
TypeError: Return value of Mbna\RomanNumerals::parse() must be of the type integer, none returned

/var/www/dev/Prospective/Mbna/src/Mbna/RomanNumerals.php:32
/var/www/dev/Prospective/Mbna/tests/unit/RomanNumeralsTest.php:33

ERRORS!
Tests: 3, Assertions: 1, Errors: 2.
```

- Enhance the test-suite with a data provider comprising Roman Numerals vs. Integers.

```
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
```

- Write the `testGenerate` and `testParse` methods, to be fed the data.

- Embark upon an iterative process - start writing business logic in `Mbna\RomanNumerals` and keep running the tests until they pass.

- Continue running `vendor/bin/phpunit --bootstrap vendor/autoload.php tests` until all complete:

```
vendor/bin/phpunit --bootstrap vendor/autoload.php tests
PHPUnit 7.1-gfafd3c555 by Sebastian Bergmann and contributors.

.........................................                         41 / 41 (100%)

Time: 103 ms, Memory: 4.00MB

OK (41 tests, 41 assertions)
```

- Create virtual host on Apache2: `mbna.local` and a simple `index.php` using the `Mbna\RomanNumerals` code.

- Commit to `git` and `push` to GitHub.

```
$ echo 'vendor' > .gitignore
$ git add . 
$ git commit -m 'Roman Numerals application.'
$ git remote add origin https://github.com/qcsc/roman-numerals.git
$ git commit -am 'Finished README.md.'
$ git push -u origin master
```
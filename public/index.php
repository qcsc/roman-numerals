<?php

require_once '../vendor/autoload.php';

$generatedRomanNumeral = $parsedRomanNumeral = null;

if (isset($_GET['submit_integer']))
{
    $generatedRomanNumeral = (new \Mbna\RomanNumerals)->generate($_GET['integer']);
}

if (isset($_GET['submit_roman_numeral']))
{
    $parsedRomanNumeral = (new \Mbna\RomanNumerals)->parse($_GET['roman_numeral']);
}

?>

<h3>Generate a Roman Numeral</h3>

<?php if ($generatedRomanNumeral) : ?>
<p>You generated: <?php echo $generatedRomanNumeral; ?></p>
<?php endif; ?>

<form>
    <input name="integer" value="<?php echo isset($parsedRomanNumeral) ? $parsedRomanNumeral : null; ?>" />
    <input type="submit" name="submit_integer" value="Generate Roman Numeral" />
</form>


<h3>Parse a Roman Numeral</h3>

<?php if ($parsedRomanNumeral) : ?>
    <p>Integer representation of Roman Numeral: <?php echo $parsedRomanNumeral; ?></p>
<?php endif; ?>

<form>
    <input name="roman_numeral" value="<?php echo isset($generatedRomanNumeral) ? $generatedRomanNumeral : null; ?>" />
    <input type="submit" name="submit_roman_numeral" value="Parse Roman Numeral" />
</form>

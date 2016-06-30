<?php

use SSNepenthe\RecipeScraper\Normalizers\Number;

class ListItemTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new Number;
    }

    public function test_replace_words_with_digits()
    {
        $words = [
            'twenty', 'nineteen', 'eighteen', 'seventeen', 'sixteen',
            'fifteen', 'fourteen', 'thirteen', 'twelve', 'eleven', 'ten',
            'nine', 'eight', 'seven', 'six', 'five', 'four', 'three', 'two',
            'one'
        ];

        $digits = [
            '20', '19', '18', '17', '16', '15', '14', '13', '12', '11',
            '10', '9', '8', '7', '6', '5', '4', '3', '2', '1'
        ];

        $this->assertEquals(
            $digits,
            $this->normalizer->normalize($words)
        );
    }
}

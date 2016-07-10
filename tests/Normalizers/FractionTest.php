<?php

use SSNepenthe\RecipeScraper\Normalizers\Fraction;

class FractionTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new Fraction;
    }

    public function test_replace_fractions()
    {
        $this->assertEquals(
            ['1/8', '1/4', '1/3', '3/8', '1/2', '5/8', '2/3', '3/4', '7/8'],
            $this->normalizer->normalize(
                ['⅛', '¼', '⅓', '⅜', '½', '⅝', '⅔', '¾', '⅞']
            )
        );
    }

    public function test_add_a_space_before_fractions()
    {
        $this->assertEquals(
            ['1 1/8 cup'],
            $this->normalizer->normalize(['1⅛ cup'])
        );
    }
}

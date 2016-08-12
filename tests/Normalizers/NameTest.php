<?php

use SSNepenthe\RecipeScraper\Normalizers\Name;

class NameTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new Name;
    }

    public function test_strip_capital_by()
    {
        $this->assertEquals(
            ['Lemonade Layer Cake'],
            $this->normalizer->normalize(['Lemonade Layer Cake Recipe'])
        );
    }
}

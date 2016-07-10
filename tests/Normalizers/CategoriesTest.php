<?php

use SSNepenthe\RecipeScraper\Normalizers\Categories;

class CategoriesTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new Categories;
    }

    public function test_strip_capital_key()
    {
        $this->assertEquals(
            ['Some Category'],
            $this->normalizer->normalize(['Key Some Category'])
        );
    }

    public function test_strip_lowercase_key()
    {
        $this->assertEquals(
            ['Some Category'],
            $this->normalizer->normalize(['key Some Category'])
        );
    }

    public function test_strip_key_colon()
    {
        $this->assertEquals(
            ['Some Category'],
            $this->normalizer->normalize(['Key: Some Category'])
        );
    }

    public function test_normalize_multiple_values()
    {
        $strings = [
            'Key Some Category',
            'key Some Category',
            'Key: Some Category',
            'key: Some Category',
        ];
        $normalized = array_fill(0, count($strings), 'Some Category');

        $this->assertEquals(
            $normalized,
            $this->normalizer->normalize($strings)
        );
    }
}

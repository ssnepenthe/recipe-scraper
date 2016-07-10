<?php

use SSNepenthe\RecipeScraper\Normalizers\OrderedList;

class OrderedListTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new OrderedList;
    }

    public function test_strip_leading_digit_period()
    {
        $this->assertEquals(
            ['Test list item.'],
            $this->normalizer->normalize(['1. Test list item.'])
        );
    }

    public function test_normalize_multiple_values()
    {
        $strings = ['1. List Item', '2. List Item', '3. List Item'];
        $normalized = array_fill(0, count($strings), 'List Item');

        $this->assertEquals(
            $normalized,
            $this->normalizer->normalize($strings)
        );
    }
}

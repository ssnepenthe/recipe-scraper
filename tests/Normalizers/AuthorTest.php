<?php

use SSNepenthe\RecipeScraper\Normalizers\Author;

class AuthorTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new Author;
    }

    public function test_strip_capital_by()
    {
        $this->assertEquals(
            ['Some Guy'],
            $this->normalizer->normalize(['By Some Guy'])
        );
    }

    public function test_strip_lowercase_by()
    {
        $this->assertEquals(
            ['Some Guy'],
            $this->normalizer->normalize(['by Some Guy'])
        );
    }

    public function test_strip_by_colon()
    {
        $this->assertEquals(
            ['Some Guy'],
            $this->normalizer->normalize(['By: Some Guy'])
        );
    }

    public function test_normalize_multiple_values()
    {
        $strings = [
            'By Some Guy',
            'by Some Guy',
            'By: Some Guy',
            'by: Some Guy',
        ];
        $normalized = array_fill(0, count($strings), 'Some Guy');

        $this->assertEquals(
            $normalized,
            $this->normalizer->normalize($strings)
        );
    }
}

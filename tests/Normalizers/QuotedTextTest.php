<?php

use SSNepenthe\RecipeScraper\Normalizers\QuotedText;

class QuotedTextTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new QuotedText;
    }

    public function test_strip_leading_and_trailing_quotes()
    {
        $this->assertEquals(
            ['Test list item.'],
            $this->normalizer->normalize(['"Test list item."'])
        );
    }
}

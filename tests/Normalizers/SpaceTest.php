<?php

use SSNepenthe\RecipeScraper\Normalizers\Space;

class SpaceTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new Space;
    }

    public function test_replace_all_space_characters()
    {
        $characters = [
            '&nbsp;', '&#160;', "\xC2\xA0", "\xE2\x80\x80", "\xE2\x80\x81",
            "\xE2\x80\x82", "\xE2\x80\x83", "\xE2\x80\x84", "\xE2\x80\x85",
            "\xE2\x80\x86", "\xE2\x80\x87", "\xE2\x80\x88", "\xE2\x80\x89",
            "\xE2\x80\x8A", "\xE2\x80\xAF", "\xE2\x81\x9F", "\xE3\x80\x80"
        ];

        foreach ($characters as $key => $value) {
            $characters[ $key ] = 'a' . $value . 'b';
        }

        $this->assertEquals(
            array_fill(0, count($characters), 'a b'),
            $this->normalizer->normalize($characters)
        );
    }

    public function test_replace_multiple_spaces_with_single_space()
    {
        $this->assertEquals(['a b'], $this->normalizer->normalize(['a   b']));
    }
}

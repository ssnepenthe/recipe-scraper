<?php

use SSNepenthe\RecipeScraper\Normalizers\EndOfLine;

class EndOfLineTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new EndOfLine;
    }

    public function test_replace_cr_character()
    {
        $string = ["Just\rA\rMulti-line\rString"];

        $this->assertEquals(
            [sprintf('Just%1$sA%1$sMulti-line%1$sString', PHP_EOL)],
            $this->normalizer->normalize($string)
        );
    }

    public function test_replace_lf_character()
    {
        $string = ["Just\nA\nMulti-line\nString"];

        $this->assertEquals(
            [sprintf('Just%1$sA%1$sMulti-line%1$sString', PHP_EOL)],
            $this->normalizer->normalize($string)
        );
    }

    public function test_replace_crlf_character()
    {
        $string = ["Just\r\nA\r\nMulti-line\r\nString"];

        $this->assertEquals(
            [sprintf('Just%1$sA%1$sMulti-line%1$sString', PHP_EOL)],
            $this->normalizer->normalize($string)
        );
    }

    public function test_reduce_multiple_newline_to_single_newline()
    {
        $string = ["Just\nA\n\nMulti-line\n\n\nString"];

        $this->assertEquals(
            [sprintf('Just%1$sA%1$sMulti-line%1$sString', PHP_EOL)],
            $this->normalizer->normalize($string)
        );
    }

    public function test_normalize_multiple_values()
    {
        $orig = "Just\rA\nMulti-line\r\nString";
        $normalized = sprintf('Just%1$sA%1$sMulti-line%1$sString', PHP_EOL);

        $this->assertEquals(
            array_fill(0, 5, $normalized),
            $this->normalizer->normalize(array_fill(0, 5, $orig))
        );
    }
}

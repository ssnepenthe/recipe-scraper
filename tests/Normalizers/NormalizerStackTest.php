<?php

use SSNepenthe\RecipeScraper\Normalizers\Author;
use SSNepenthe\RecipeScraper\Normalizers\Fraction;
use SSNepenthe\RecipeScraper\Normalizers\EndOfLine;
use SSNepenthe\RecipeScraper\Normalizers\NormalizerStack;

/**
 * @todo Come up with a good way to test order in which normalizers are run.
 */
class NormalizerStackTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new NormalizerStack;
    }

    public function test_single_normalizer()
    {
        $this->normalizer->push(new Author);

        $this->assertEquals(
            ['That One Guy'],
            $this->normalizer->normalize(['By That One Guy'])
        );
    }

    public function test_multiple_normalizers()
    {
        $this->normalizer->push(new EndOfLine);
        $this->normalizer->push(new Fraction);

        $this->assertEquals(
            [sprintf("One%sTwo", PHP_EOL), '1/8', sprintf('1/8%s2/3', PHP_EOL)],
            $this->normalizer->normalize(["One\rTwo", '⅛', "⅛\n⅔"])
        );
    }
}

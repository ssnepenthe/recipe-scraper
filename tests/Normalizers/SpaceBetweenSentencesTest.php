<?php

use SSNepenthe\RecipeScraper\Normalizers\SpaceBetweenSentences;

class SpaceBetweenSentencesTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new SpaceBetweenSentences;
    }

    public function test_add_space_after_period()
    {
        $this->assertEquals(
            ['One sentence. Another sentence.'],
            $this->normalizer->normalize(['One sentence.Another sentence.'])
        );
    }

    public function test_add_space_after_paren()
    {
        $this->assertEquals(
            ['One sentence) Another sentence.'],
            $this->normalizer->normalize(['One sentence)Another sentence.'])
        );
    }
}

<?php

use SSNepenthe\RecipeScraper\Normalizers\RecipeInstructions;

class RecipeInstructionsTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new RecipeInstructions;
    }

    public function test_remove_photographs_by()
    {
        $this->assertEquals(
            ['Value'],
            $this->normalizer->normalize([
                'Value',
                'Photographs by This Dude and That Dude'
            ])
        );
    }

    public function test_remove_photograph_by()
    {
        $this->assertEquals(
            ['Value'],
            $this->normalizer->normalize([
                'Value',
                'Photograph by This Dude and That Dude'
            ])
        );
    }

    public function test_remove_per_serving()
    {
        $this->assertEquals(
            ['Value'],
            $this->normalizer->normalize([
                'Value',
                'Per serving: something something'
            ])
        );
    }

    public function test_remove_copyright()
    {
        $this->assertEquals(
            ['Value'],
            $this->normalizer->normalize([
                'Value',
                'Copyright Such and Such Magazine'
            ])
        );
    }

    public function test_normalize_multiple_values()
    {
        $strings = [
            'Value',
            'Photographs by This Dude and That Dude',
            'Photograph by This Dude and That Dude',
            'Per serving: something something',
            'Copyright Such and Such Magazine',
        ];

        $this->assertEquals(
            ['Value'],
            $this->normalizer->normalize($strings)
        );
    }
}

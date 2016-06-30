<?php

use SSNepenthe\RecipeScraper\Normalizers\RecipeYield;

class RecipeYieldTest extends PHPUnit_Framework_TestCase
{
    protected $normalizer;

    public function setUp()
    {
        $this->normalizer = new RecipeYield;
    }

    public function test_strip_make()
    {
        $strings = [
            'Make 1',
            'make 1',
            'Make: 1',
            'make: 1',
            'Makes 1',
            'makes 1',
            'Makes: 1',
            'makes: 1',
        ];

        $this->assertEquals(
            array_fill(0, count($strings), '1'),
            $this->normalizer->normalize($strings)
        );
    }

    public function test_strip_serve()
    {
        $strings = [
            'Serve 2',
            'serve 2',
            'Serve: 2',
            'serve: 2',
            'Serves 2',
            'serves 2',
            'Serves: 2',
            'serves: 2',
        ];

        $this->assertEquals(
            array_fill(0, count($strings), '2'),
            $this->normalizer->normalize($strings)
        );
    }

    public function test_strip_serving()
    {
        $strings = [
            'Serving 3',
            'serving 3',
            'Serving: 3',
            'serving: 3',
            'Servings 3',
            'servings 3',
            'Servings: 3',
            'servings: 3',
        ];

        $this->assertEquals(
            array_fill(0, count($strings), '3'),
            $this->normalizer->normalize($strings)
        );
    }

    public function test_strip_yield()
    {
        $strings = [
            'Yield 4',
            'yield 4',
            'Yield: 4',
            'yield: 4',
            'Yields 4',
            'yields 4',
            'Yields: 4',
            'yields: 4',
        ];

        $this->assertEquals(
            array_fill(0, count($strings), '4'),
            $this->normalizer->normalize($strings)
        );
    }

    public function test_normalize_my_recipes_com_yield()
    {
        $this->assertEquals(
            ['5'],
            $this->normalizer->normalize(
                ['Serves 5 (serving size: 1 piece)']
            )
        );
    }
}

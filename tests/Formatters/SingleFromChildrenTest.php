<?php

use SSNepenthe\RecipeScraper\Normalizers\Space;
use SSNepenthe\RecipeScraper\Normalizers\EndOfLine;
use SSNepenthe\RecipeScraper\Normalizers\SingleLine;
use SSNepenthe\RecipeScraper\Normalizers\NormalizerStack;
use SSNepenthe\RecipeScraper\Formatters\SingleFromChildren;

class SingleFromChildrenTest extends CachedHTTPTestCase
{
    protected $formatter;

    public function setUp()
    {
        $this->formatter = new SingleFromChildren;
    }

    public function test_single_item_single_location()
    {
        $crawler = $this->client->request(
            'GET',
            'http://spryliving.com/recipes/grilled-salmon-with-pesto/'
        );

        $filtered = $crawler->filter('[itemprop="ingredients"]');
        $config = ['locations' => ['_text', 'content']];

        $this->assertEquals(
            ['coconut oil, for grilling'],
            $this->formatter->format($filtered, $config)
        );
    }

    public function test_mark_item_as_title()
    {
        $crawler = $this->client->request(
            'GET',
            'http://www.bettycrocker.com/recipes/banana-peanut-butter-and-marshmallow-poke-cake/5e2b9f28-7d7e-4ce2-af66-6a958d47046c'
        );

        $filtered = $crawler->filter('.recipePartIngredientGroup h2, .recipePartIngredientGroup dl');
        $config = ['locations' => ['_text']];

        // There will be some wacky spacing so we need to normalize as well.
        $normalizer = new NormalizerStack;
        $normalizer->push(new EndOfLine);
        $normalizer->push(new SingleLine);
        $normalizer->push(new Space);

        $this->assertEquals(
            ['%%TITLE%%Cake%%TITLE%%',],
            $normalizer->normalize($this->formatter->format($filtered, $config))
        );
    }
}

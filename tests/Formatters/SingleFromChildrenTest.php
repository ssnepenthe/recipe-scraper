<?php

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
            [
			    'coconut oil, for grilling 2 cups garlic scapes 2 cups packed kale leaves 1/2 cup olive oil 1/2 cup grated Parmesan or pecorino Romano cheese 1/4 teaspoon salt 1/8 teaspoon freshly ground black pepper 1 pound (4 filets) wild salmon, skin intact 1 pound yellow squash, sliced into ¼-inch strips',
            ],
            $this->formatter->format($filtered, $config)
        );
    }
}

# recipe-scraper
A recipe scraping library which makes it easy to scrape recipes from popular sites around the web.

Current site support is still limited. See [issue #1](https://github.com/ssnepenthe/recipe-scraper/issues/1) for a full list.

## Requirements
Composer, PHP 5.5 or later.

## Installation
```
composer require ssnepenthe/recipe-scraper
```

## Usage
Scraper instances work on Symfony DomCrawler instances. These can be created however you choose, but the easiest is to use a BrowserKit implementation like Goutte:

```
$client = new Goutte\Client;
$crawler = $client->request('GET', 'http://allrecipes.com/recipe/139917/joses-shrimp-ceviche/');
```

All scrapers require an instance of `ExtractorManager`:

```
$extractor = new SSNepenthe\RecipeScraper\Extractors\ExtractorManager;
```

If you only need to scrape recipes from a single site, you can use the corresponding class from `src/Scrapers`:

```
$scraper = new SSNepenthe\RecipeScraper\Scrapers\AllRecipesCom($extractor);
```

Check whether a scraper supports a given crawler using the `->supports()` method:

```
$scraper->supports($crawler); // true
```

If you want to be able to scrape recipes from all supported sites, create a `DelegatingScraper` using the `ScraperFactory`:

```
$scraper = SSNepenthe\RecipeScraper\Scrapers\ScraperFactory::make();
```

Finally, scrape a recipe by passing the crawler to the `->scrape()` method:

```
$recipe = $scraper->scrape($crawler);
```

The following properties are guaranteed to be set on the `$recipe` array:

```
$recipe['author'] // string|null
$recipe['categories'] // string[]|null
$recipe['cookingMethod'] // string|null
$recipe['cookTime'] // string|null
$recipe['cuisines'] // string[]|null
$recipe['description'] // string|null
$recipe['image'] // string|null
$recipe['ingredients'] // string[]|null
$recipe['instructions'] // string[]|null
$recipe['name'] // string|null
$recipe['prepTime'] // string|null
$recipe['publisher'] // string|null
$recipe['totalTime'] // string|null
$recipe['url'] // string|null
$recipe['yield'] // string|null
```

Altogether:

```
$client = new Goutte\Client;
$crawler = $client->request('GET', 'http://allrecipes.com/recipe/139917/joses-shrimp-ceviche/');
$scraper = SSNepenthe\RecipeScraper\Scrapers\ScraperFactory::make();

$recipe = $scraper->scrape($crawler);

var_dump($recipe);
```

OUTPUT:

```
array(15) {
    'author' => string(9) "carrielee"
    'categories' => NULL
    'cookingMethod' => NULL
    'cookTime' => string(5) "PT10M"
    'cuisines' => NULL
    'description' => string(336) ""I've looked all over the net and haven't found a shrimp ceviche quite like this one! My friends absolutely love it and beg me for the recipe! You can always double it for larger parties--it goes FAST! Serve as a dip with tortilla chips or as a topping on a tostada spread with mayo. The fearless palate might like this with hot sauce.""
    'image' => string(65) "http://images.media-allrecipes.com/userphotos/560x315/1364063.jpg"
    'ingredients' => array(9) {
        [0] => string(41) "1 pound peeled and deveined medium shrimp"
        [1] => string(22) "1 cup fresh lime juice"
        [2] => string(23) "10 plum tomatoes, diced"
        [3] => string(27) "1 large yellow onion, diced"
        [4] => string(49) "1 jalapeno pepper, seeded and minced, or to taste"
        [5] => string(28) "2 avocados, diced (optional)"
        [6] => string(31) "2 ribs celery, diced (optional)"
        [7] => string(31) "chopped fresh cilantro to taste"
        [8] => string(24) "salt and pepper to taste"
    }
    'instructions' => array(2) {
        [0] => string(294) "Place shrimp in a glass bowl and cover with lime juice to marinate (or 'cook') for about 10 minutes, or until they turn pink and opaque. Meanwhile, place the plum tomatoes, onion and jalapeno (and avocados and celery, if using) in a large, non-reactive (stainless steel, glass or plastic) bowl."
        [1] => string(200) "Remove shrimp from lime juice, reserving juice. Dice shrimp and add to the bowl of vegetables. Pour in the remaining lime juice marinade. Add cilantro and salt and pepper to taste. Toss gently to mix."
    }
    'name' => string(21) "Jose's Shrimp Ceviche"
    'prepTime' => string(5) "PT45M"
    'publisher' => NULL
    'totalTime' => string(5) "PT55M"
    'url' => string(57) "http://allrecipes.com/recipe/139917/joses-shrimp-ceviche/"
    'yield' => string(2) "20"
}
```

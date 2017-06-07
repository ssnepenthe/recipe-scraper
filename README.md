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

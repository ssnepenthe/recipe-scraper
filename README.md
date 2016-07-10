# recipe-scraper
A recipe scraping library which makes it easy to scrape recipes from popular sites around the web.

Current site support is still limited. See [issue #1](https://github.com/ssnepenthe/recipe-scraper/issues/1) for a full list.

## Usage
```
composer require ssnepenthe/recipe-scraper
```

Make sure you have included the composer autoloader and then:

```
use SSNepenthe\RecipeScraper\Client;

$client = new Client;

$recipe = $client->scrape('http://allrecipes.com/recipe/8652/garlic-chicken/');
```

The following properties are available on the `$recipe` object:

```
$recipe->description : string
$recipe->image : string
$recipe->name : string
$recipe->url : string
$recipe->author : string
$recipe->publisher : string
$recipe->cookTime : DateInterval
$recipe->cookingMethod : string
$recipe->prepTime : DateInterval
$recipe->recipeInstructions : array
$recipe->recipeYield : string
$recipe->totalTime : DateInterval
$recipe->recipeCategories : array
$recipe->recipeCuisines : array
$recipe->recipeIngredients : array
```

## Caching
To cache client responses, first install `doctrine/cache` and `kevinrob/guzzle-cache-middleware`.

```
composer require doctrine/cache
composer require kevinrob/guzzle-cache-middleware
```

Then enable the filesystem cache by calling `enableGreedyFileCache()`.

```
use SSNepenthe\RecipeScraper\Client;

$client = new Client;
// First param is cache path - optional, default is '.cache'.
// Second param is cache lifetime in seconds - optional, default is 60 * 60 * 24.
$client->enableGreedyFileCache('/path/to/cache/dir', 60 * 60);

$recipe = $client->scrape('http://allrecipes.com/recipe/8652/garlic-chicken/');
```

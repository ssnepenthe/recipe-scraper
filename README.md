# recipe-parser
A recipe parsing library which makes it easy to scrape recipes from popular sites around the web.

Current site support is still limited. See [issue #1](https://github.com/ssnepenthe/recipe-parser/issues/1) for a full list.

## Usage
```
composer require ssnepenthe/recipe-parser
```

Make sure you have included the composer autoloader and then:

```
use SSNepenthe\RecipeParser\RecipeParser;
use SSNepenthe\RecipeParser\Http\CurlClient;
use SSNepenthe\RecipeParser\Cache\DoctrineFSCache;

$http = new CurlClient;
$cache = new DoctrineFSCache('/path/to/cache/dir');

$parser = new RecipeParser($http, $cache);
$recipe = $parser->parse('http://recipe.page/on/some/website');

var_dump($recipe->recipeInstructions);
```
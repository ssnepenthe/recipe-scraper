<?php

namespace SSNepenthe\RecipeScraper\Exception;

use RuntimeException;
use SSNepenthe\RecipeScraper\Interfaces\RecipeScraperException;

class NoMatchingScraperException extends RuntimeException implements RecipeScraperException
{
}

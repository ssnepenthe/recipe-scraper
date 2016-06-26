<?php

namespace SSNepenthe\RecipeParser\Exception;

use RuntimeException;
use SSNepenthe\RecipeParser\Interfaces\RecipeParserExceptionInterface;

class NoMatchingParserException extends RuntimeException implements RecipeParserExceptionInterface
{
}

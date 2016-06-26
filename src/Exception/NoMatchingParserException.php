<?php

namespace SSNepenthe\RecipeParser\Exception;

use RuntimeException;
use SSNepenthe\RecipeParser\Interfaces\RecipeParserException;

class NoMatchingParserException extends RuntimeException implements RecipeParserException
{
}

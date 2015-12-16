<?php

namespace SSNepenthe\RecipeParser\Exception;

use RuntimeException;
use SSNepenthe\RecipeParser\Contracts\RecipeParserExceptionInterface as RecipeParserException;

class NoMatchingParserException extends RuntimeException implements RecipeParserException {}

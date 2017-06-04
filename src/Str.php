<?php

namespace SSNepenthe\RecipeScraper;

use function Stringy\create as s;

class Str
{
	public static function normalize($value)
	{
		return s($value)
			->htmlDecode()
			->tidy()
			->trim()
			->collapseWhitespace()
			->__toString();
	}
}

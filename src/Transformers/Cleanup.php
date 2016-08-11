<?php

namespace SSNepenthe\RecipeScraper\Transformers;

use SSNepenthe\RecipeScraper\Interfaces\Transformer;

class Cleanup implements Transformer
{
    public function transform(array $values)
    {
        return array_map(function($value) {
        	return trim(str_replace('%%TITLE%%', '', $value));
        }, $values);
    }
}

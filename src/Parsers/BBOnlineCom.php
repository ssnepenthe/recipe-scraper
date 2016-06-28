<?php

namespace SSNepenthe\RecipeParser\Parsers;

class BBOnlineCom extends SchemaOrg
{
    protected function configure()
    {
        parent::configure();

        $this->config['recipeInstructions']['selector'] = '[itemprop="recipeInstructions"] p';
        $this->config['recipeIngredients']['selector'] = '[itemprop="ingredients"]';
    }

    protected function normalizeCookTime($value) {
    	if (! $value) {
    		return $value;
    	}

    	list($hour, $minute, $second) = explode(':', $value);

    	$time = sprintf('PT%sH%sM%sS', $hour, $minute, $second);

    	return $time;
    }

    protected function normalizePrepTime($value) {
    	if (! $value) {
    		return $value;
    	}

    	list($hour, $minute, $second) = explode(':', $value);

    	$time = sprintf('PT%sH%sM%sS', $hour, $minute, $second);

    	return $time;
    }

    protected function normalizeTotalTime($value) {
    	if (! $value) {
    		return $value;
    	}

    	list($hour, $minute, $second) = explode(':', $value);

    	$time = sprintf('PT%sH%sM%sS', $hour, $minute, $second);

    	return $time;
    }
}

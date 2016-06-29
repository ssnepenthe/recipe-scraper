<?php

namespace SSNepenthe\RecipeParser\Parsers;

/**
 * @todo Potentially more categories available with javascript support.
 */
class FoodNetworkCom extends SchemaOrg
{
    protected function configure()
    {
        parent::configure();

        $this->config['author']['selector'] = '[itemprop="author"] [itemprop="name"]';

        // I don't want the description they actually provide.
        $this->config['description']['selector'] = '[itemprop="fakedescription"]';

        $this->config['image']['selector'] = '.photo-video [itemprop="image"]';
        $this->config['recipeIngredients']['selector'] = '.ingredients li';
        $this->config['recipeInstructions']['selector'] = '.recipe-directions-list li';
    }

    protected function normalizeRecipeInstructions($instructions)
    {
        $instructions = parent::normalizeRecipeInstructions($instructions);

        $instructions = $this->stripCopyrightFromInstructions($instructions);
        $instructions = $this->stripNutritionFromInstructions($instructions);
        $instructions = $this->stripPhotoCreditFromInstructions($instructions);

        return $instructions;
    }

    protected function stripPhotoCreditFromInstructions(array $instructions)
    {
        return array_filter($instructions, function ($value) {
            return 1 !== preg_match('/Photographs? by/', $value);
        });
    }

    protected function stripNutritionFromInstructions(array $instructions)
    {
        return array_filter($instructions, function ($value) {
            return false === strpos($value, 'Per serving: ');
        });
    }

    protected function stripCopyrightFromInstructions(array $instructions)
    {
        return array_filter($instructions, function ($value) {
            return false === strpos($value, 'Copyright');
        });
    }
}

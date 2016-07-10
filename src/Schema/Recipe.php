<?php
/**
 * Schema.org Recipe. Not complete and modified slightly to better match
 * implementations found in the wild.
 */

namespace SSNepenthe\RecipeScraper\Schema;

/**
 * This class represents a Recipe object as defined by schema.org. It has been
 * paired down to only include properties useful when scraping recipes from
 * around the web.
 *
 * @link https://schema.org/Recipe
 *
 * @todo Consider how we could support recipe notes, maybe as 'comment' property.
 *       Consider adding support for the 'nutrition' property.
 *       Consider adding support for the 'suitableForDiet' property.
 */
class Recipe extends CreativeWork
{
    public function __construct()
    {
        parent::__construct();

        $keys = [
            'cookTime',
            'cookingMethod',
            'prepTime',
            'recipeInstructions',
            'recipeYield',
            'totalTime',

            // Pluralized form of schema.org supported properties.
            'recipeCategories',
            'recipeCuisines',
            'recipeIngredients',
        ];

        foreach ($keys as $key) {
            $this->properties[ $key ] = null;
        }
    }

    public function setCookTime($value)
    {
        $this->setDuration('cookTime', $value);
    }

    public function setCookingMethod($value)
    {
        $this->setText('cookingMethod', $value);
    }

    public function setPrepTime($value)
    {
        $this->setDuration('prepTime', $value);
    }

    public function setRecipeCategories(array $value)
    {
        $this->setTextList('recipeCategories', $value);
    }

    public function setRecipeCuisines(array $value)
    {
        $this->setTextList('recipeCuisines', $value);
    }

    public function setRecipeIngredients(array $value)
    {
        $this->setGroupList('recipeIngredients', $value);
    }

    public function setRecipeInstructions(array $value)
    {
        $this->setGroupList('recipeInstructions', $value);
    }

    public function setRecipeYield($value)
    {
        $this->setText('recipeYield', $value);
    }

    public function setTotalTime($value)
    {
        $this->setDuration('totalTime', $value);
    }

    /**
     * Return totalTime if set, otherwise calculate from prep + cook times.
     *
     * @return \DateInterval
     */
    public function totalTime()
    {
        if (! is_null($this->properties['totalTime'])) {
            return $this->properties['totalTime'];
        }

        $now = new \DateTime('now');
        $later = clone $now;

        if (! is_null($this->properties['cookTime'])) {
            $later->add($this->properties['cookTime']);
        }

        if (! is_null($this->properties['prepTime'])) {
            $later->add($this->properties['prepTime']);
        }

        if ($later == $now) {
            return null;
        }

        return $now->diff($later);
    }

    /**
     * Throw an exception if array contains anything but string values.
     *
     * @param  array  $value [description]
     *
     * @throws \InvalidArgumentException When non-string entries are found.
     */
    protected function assertArrayOfStrings(array $value)
    {
        array_walk($value, function ($v, $k) {
            if (! is_string($v)) {
                throw new \InvalidArgumentException(sprintf(
                    'All entries in the value property are required to be string, %s found at index %s',
                    gettype($v),
                    $k
                ));
            }
        });
    }

    /**
     * Set a property to a \DateInterval value.
     *
     * @param string        $key   Valid recipe property name.
     * @param \DateInterval $value Duration to set.
     */
    protected function setDuration($key, \DateInterval $value)
    {
        $this->assertValidProperty($key);

        $this->properties[ $key ] = $value;
    }

    /**
     * Set a property to an array of arrays each with title and data.
     *
     * @param string $key   Valid recipe property name.
     * @param array  $value Group list.
     *
     * @throws \InvalidArgumentException When entry in $value is not array.
     * @throws \InvalidArgumentException When entry does not have title or data.
     * @throws \InvalidArgumentException When title or data ar of wrong type.
     */
    protected function setGroupList($key, array $value)
    {
        $this->assertValidProperty($key);

        array_walk($value, function ($v, $k) {
            if (! is_array($v)) {
                throw new \InvalidArgumentException(sprintf(
                    'Group list values must be array, %s found',
                    gettype($v)
                ));
            }

            if (! isset($v['title']) || ! isset($v['data'])) {
                throw new \InvalidArgumentException(
                    'Group list values must contain a title and a data entry'
                );
            }

            if (! is_string($v['title']) || ! is_array($v['data'])) {
                throw new \InvalidArgumentException(
                    'Group list values must contain a title (string) and data (array)'
                );
            }

            $this->assertArrayOfStrings($v['data']);
        });

        $this->properties[ $key ] = $value;
    }

    /**
     * Set a property to an array of strings.
     *
     * @param string $key   Valid recipe property name.
     * @param array  $value Array of strings to set.
     */
    protected function setTextList($key, array $value)
    {
        $this->assertValidProperty($key);
        $this->assertArrayOfStrings($value);

        $this->properties[ $key ] = $value;
    }
}

<?php
/**
 * Schema.org Thing. Not complete, tailored around recipes. Also modified
 * slightly to better match implementations found in the wild.
 */

namespace SSNepenthe\RecipeScraper\Schema;

/**
 * This class represents a Thing object as defined by schema.org. It has
 * been paired down significantly to only include properties desirable on the
 * Recipe sub-object.
 *
 * @link https://schema.org/Thing
 */
class Thing
{
    protected $properties = [];

    public function __construct()
    {
        $keys = [
            'description',
            'image',
            'name',
            'url',
        ];

        foreach ($keys as $key) {
            $this->properties[ $key ] = null;
        }
    }

    public function __get($key)
    {
        if (! array_key_exists($key, $this->properties)) {
            return null;
        }

        if (method_exists($this, $key)) {
            return $this->$key();
        }

        return $this->properties[ $key ];
    }

    public function getKeys()
    {
        return array_keys($this->properties);
    }

    public function setDescription($value)
    {
        $this->setText('description', $value);
    }

    public function setImage($value)
    {
        $this->setText('image', $value);
    }

    public function setName($value)
    {
        $this->setText('name', $value);
    }

    public function setUrl($value)
    {
        $this->setText('url', $value);
    }

    /**
     * Throw an exception if provided an invalid property name.
     *
     * @param  string $key Property name to check validity of.
     *
     * @throws \InvalidArgumentException When key is not a string.
     * @throws \RuntimeException When key is not a valid property.
     */
    protected function assertValidProperty($key)
    {
        if (! is_string($key)) {
            throw new \InvalidArgumentException(sprintf(
                'The key property is required to be string, was: %s',
                gettype($value)
            ));
        }

        if (! array_key_exists($key, $this->properties)) {
            throw new \RuntimeException(sprintf(
                '%s is not a valid property of %s',
                $key,
                __CLASS__
            ));
        }
    }

    /**
     * Set a property ro a string value.
     *
     * @param string $key   A valid recipe property name.
     * @param string $value The string value to set.
     *
     * @throws \InvalidArgumentException When value is not a string.
     */
    protected function setText($key, $value)
    {
        $this->assertValidProperty($key);

        if (! is_string($value)) {
            throw new \InvalidArgumentException(sprintf(
                'The value property is required to be string, was: %s',
                gettype($value)
            ));
        }

        $this->properties[ $key ] = $value;
    }
}

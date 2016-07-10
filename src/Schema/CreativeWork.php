<?php
/**
 * Schema.org CreativeWork. Not complete, tailored around recipes. Also modified
 * slightly to better match implementations found in the wild.
 */

namespace SSNepenthe\RecipeScraper\Schema;

/**
 * This class represents a CreativeWork object as defined by schema.org. It has
 * been paired down significantly to only include properties desirable on the
 * Recipe sub-object.
 *
 * @link https://schema.org/CreativeWork
 *
 * @todo Might consider adding support for 'video' property.
 */
class CreativeWork extends Thing
{
    public function __construct()
    {
        parent::__construct();

        $keys = [
            'author',
            'publisher',
        ];

        foreach ($keys as $key) {
            $this->properties[ $key ] = null;
        }
    }

    /**
     * Should technically be Organization OR Person object, not text.
     */
    public function setAuthor($value)
    {
        $this->setText('author', $value);
    }

    /**
     * Should technically be Organization object, not text.
     */
    public function setPublisher($value)
    {
        $this->setText('publisher', $value);
    }
}

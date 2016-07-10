<?php

namespace SSNepenthe\RecipeScraper\Scrapers;

use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Schema\Recipe;
use SSNepenthe\RecipeScraper\Formatters\Single;
use SSNepenthe\RecipeScraper\Normalizers\Space;
use SSNepenthe\RecipeScraper\Interfaces\Scraper;
use SSNepenthe\RecipeScraper\Interfaces\Formatter;
use SSNepenthe\RecipeScraper\Normalizers\Fraction;
use SSNepenthe\RecipeScraper\Normalizers\EndOfLine;
use SSNepenthe\RecipeScraper\Interfaces\Transformer;
use SSNepenthe\RecipeScraper\Normalizers\SingleLine;
use SSNepenthe\RecipeScraper\Normalizers\NormalizerStack;
use SSNepenthe\RecipeScraper\Transformers\NullTransformer;

abstract class BaseScraper implements Scraper
{
    protected $config;
    protected $crawler;
    protected $recipe;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
        $this->recipe = new Recipe;

        $this->applyScraperConfig();
        $this->applyConfigDefaults();
        $this->validateConfig();
        $this->instantiateConfigValues();
    }

    abstract protected function applyScraperConfig();

    protected function applyConfigDefaults()
    {
        if (! is_array($this->config)) {
            // @todo
            throw new \RuntimeException();
        }

        foreach ($this->config as $key => $value) {
            if (! isset($value['formatter'])) {
                $this->config[ $key ]['formatter'] = Single::class;
            }

            if (! isset($value['locations'])) {
                $this->config[ $key ]['locations'] = [
                    'datetime',
                    'content',
                    'href',
                    'data-src',
                    'src',
                    '_text',
                ];
            }

            if (! isset($value['normalizers'])) {
                // Order is important here.
                $this->config[ $key ]['normalizers'] = [
                    Fraction::class,
                    EndOfLine::class,
                    SingleLine::class,
                    Space::class,
                ];
            }

            if(! isset($value['transformer'])) {
                $this->config[ $key ]['transformer'] = NullTransformer::class;
            }
        }
    }

    protected function instantiateConfigValues()
    {
        foreach ($this->config as $key => $value) {
            // @todo Verify formatter is string?
            $this->config[ $key ]['formatter'] = new $this->config[ $key ]['formatter'];

            $normalStack = new NormalizerStack;

            foreach ($this->config[ $key ]['normalizers'] as $normalizer) {
                // @todo Verify normalizers are all strings?
                $normalStack->push(new $normalizer);
            }

            $this->config[ $key ]['normalizers'] = $normalStack;

            // @todo Verify transformer is string?
            $this->config[ $key ]['transformer'] = new $this->config[ $key ]['transformer'];
        }
    }

    protected function validateConfig()
    {
        // Compare against available keys on Recipe.
        if (! empty($invalid = array_diff(
            array_keys($this->config),
            $this->recipe->getKeys()
        ))) {
            // @todo
            throw new \RuntimeException();
        }

        foreach ($this->config as $key => $value) {
            if (! in_array(
                Formatter::class,
                class_implements($value['formatter'])
            )) {
                // @todo
                throw new \RuntimeException();
            }

            if (! is_array($value['locations']) || empty($value['locations'])) {
                // @todo
                throw new \RuntimeException();
            }

            array_walk($value['locations'], function ($v, $k) {
                if (! is_string($v)) {
                    // @todo
                    throw new \RuntimeException();
                }
            });

            if (
                ! is_array($value['normalizers']) ||
                empty($value['normalizers'])
            ) {
                // @todo
                throw new \InvalidArgumentException();
            }

            if (
                ! isset($value['selector']) ||
                ! is_string($value['selector'])
            ) {
                // @todo
                throw new \RuntimeException();
            }

            if (! in_array(
                Transformer::class,
                class_implements($value['transformer'])
            )) {
                // @todo
                throw new \RuntimeException();
            }
        }
    }

    public function scrape()
    {
        foreach ($this->config as $property => $config) {
            $filteredCrawler = $this->crawler->filter($config['selector']);

            if (! $filteredCrawler->count()) {
                continue;
            }

            $value = $config['formatter']->format($filteredCrawler, $config);
            $value = $config['normalizers']->normalize($value);
            $value = $config['transformer']->transform($value);

            // Just in case.
            if (empty($value)) {
                continue;
            }

            $setter = sprintf('set%s', ucfirst($property));

            /**
             * If there is only one item in the array we will use it directly,
             * unless we have specifically set a 'multi' formatter.
             */
            // dump($value);
            if (
                1 === count($value) &&
                false === strpos(get_class($config['formatter']), 'Multi')
            ) {
                $value = $value[0];
            }

            if ($value && method_exists($this->recipe, $setter)) {
                call_user_func([$this->recipe, $setter], $value);
            }
        }

        return $this->recipe;
    }
}

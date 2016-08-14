<?php

namespace SSNepenthe\RecipeScraper\Formatters;

use Symfony\Component\DomCrawler\Crawler;
use SSNepenthe\RecipeScraper\Interfaces\Formatter;

abstract class Base implements Formatter
{
    abstract public function format(Crawler $crawler, array $config);

    protected function looksLikeGroupTitle(Crawler $node)
    {
        $tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'strong', 'dt'];

        if (in_array($node->nodeName(), $tags)) {
            return true;
        }

        if (preg_match('/[#\*\-_=\+]{2,}/', $node->text())) {
            return true;
        }

        if (':' === substr($node->text(), -1)) {
            return true;
        }

        if (false !== strpos($node->attr('class'), 'header')) {
            return true;
        }

        if (false !== strpos($node->attr('class'), 'title')) {
            return true;
        }

        return false;
    }
}

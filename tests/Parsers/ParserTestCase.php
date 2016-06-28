<?php

class ParserTestCase extends CacheableHTTPTestCase
{
    protected $parser;
    protected $recipes = [];

    protected function recipe($url)
    {
        if (! isset($this->recipes[ $url ])) {
            $html = $this->get_and_cache($url);

            $this->parser->setHtml($html);

            $this->recipes[ $url ] = $this->parser->parse();
        }

        return $this->recipes[ $url ];
    }
}

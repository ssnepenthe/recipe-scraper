<?php

namespace RecipeScraperTests;

use Symfony\Component\DomCrawler\Crawler;

trait UsesTestData
{
    protected function getDataDir($type = null)
    {
        $dir = __DIR__ . DIRECTORY_SEPARATOR . 'data';

        if (! is_null($type)) {
            $dir .= DIRECTORY_SEPARATOR . $type;
        }

        return $dir;
    }

    protected function getDataFilePath($file, $type = null)
    {
        return $this->getDataDir($type) . DIRECTORY_SEPARATOR . $file;
    }

    protected function getHtmlFilesList()
    {
        return glob($this->getHtmlDataDir() . '/**/*');
    }

    protected function getHtml($url)
    {
        $htmlPath = $this->getHtmlDataFilePathFromUrl($url);

        if (! file_exists($htmlPath)) {
            $this->fail(
                "Unable to locate test HTML for {$url} at {$htmlPath}\n"
                    . 'Please run ./bin/test-tools get-html --missing'
            );
        }

        return file_get_contents($htmlPath);
    }

    protected function getHtmlDataDir()
    {
        return $this->getDataDir('html');
    }

    protected function getHtmlDataFilePath($file)
    {
        return $this->getDataFilePath($file, 'html');
    }

    protected function getHtmlDataFilePathFromUrl($url)
    {
        return $this->getHtmlDataFilePath(
            $this->getRelativeDataFilePathFromUrl($url)
        );
    }

    protected function getRelativeDataFilePathFromUrl($url)
    {
        $parsed = parse_url($url);

        if (! isset($parsed['host'])) {
            throw new \RuntimeException('Bad host');
        }

        $host = $this->sanitizeStringForFileName($parsed['host']);
        $path = isset($parsed['path'])
            ? $this->sanitizeStringForFileName($parsed['path'])
            : '';
        $query = isset($parsed['query'])
            ? '-' . $this->sanitizeStringForFileName($parsed['query'])
            : '';

        return $host . DIRECTORY_SEPARATOR . $path . $query;
    }

    protected function getResultsFilesList()
    {
        return glob($this->getResultsDataDir() . '/**/*.php');
    }

    protected function getResults($crawler)
    {
        $url = $crawler->getUri();
        $resultsPath = $this->getResultsDataFilePathFromUrl($url);

        if (! file_exists($resultsPath)) {
            $this->fail(
                "Unable to locate test results for {$url} at {$resultsPath}\n"
                    . 'Please run ./bin/test-tools stub-results'
            );
        }

        $results = static::includeFile($resultsPath);

        return $results;
    }

    protected function getResultsDataDir()
    {
        return $this->getDataDir('results');
    }

    protected function getResultsDataFilePath($file)
    {
        return $this->getDataFilePath($file . '.php', 'results');
    }

    protected function getResultsDataFilePathFromUrl($url)
    {
        return $this->getResultsDataFilePath(
            $this->getRelativeDataFilePathFromUrl($url)
        );
    }

    protected function getTestUrls()
    {
        $lists = glob($this->getUrlsDataDir() . '/*.php');
        $urls = [];

        foreach ($lists as $list) {
            $urls = array_merge($urls, static::includeFile($list));
        }

        return $urls;
    }

    protected function getUrlsDataDir()
    {
        return $this->getDataDir('urls');
    }

    protected function getUrlsDataFilePath($file)
    {
        return $this->getDataFilePath($file . '.php', 'urls');
    }

    protected function sanitizeStringForFileName($string)
    {
        return preg_replace(
            '/[^a-zA-Z0-9\.-]/',
            '-',
            trim($string, " \t\n\r\0\x0B/")
        );
    }

    protected static function includeFile($file)
    {
        return include $file;
    }

    protected function makeCrawler($url)
    {
        return new Crawler($this->getHtml($url), $url);
    }
}

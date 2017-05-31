<?php

namespace RecipeScraperTests;

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

        return $host . DIRECTORY_SEPARATOR . $path;
    }

    protected function getResultsDataDir()
    {
        return $this->getDataDir('results');
    }

    protected function getResultsDataFilePath($file)
    {
        return $this->getDataFilePath($file, 'results');
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
        return $this->getDataFilePath($file, 'urls');
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
}

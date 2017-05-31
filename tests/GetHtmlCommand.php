<?php

namespace RecipeScraperTests;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetHtmlCommand extends Command
{
    use UsesTestData;

    protected function configure()
    {
        $this->setName('get-html')
            ->setDescription('Download missing HTML data for tests')
            ->addOption(
                'rate',
                null,
                InputOption::VALUE_OPTIONAL,
                'Number of seconds to wait between requests',
                1
            )
            ->addOption(
                'missing',
                null,
                InputOption::VALUE_NONE,
                'Only get missing HTML data'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $missing = $input->getOption('missing');
        $rate = intval(round(
            max(0.0, floatval($input->getOption('rate'))) * 1000000
        ));

        $urls = $missing ? $this->getMissingTestUrls() : $this->getTestUrls();

        // So requests to a given host are (hopefully) a bit more spaced out.
        shuffle($urls);

        $progress = new ProgressBar($output, count($urls));
        $progress->start();

        foreach ($urls as $url) {
            // @todo Reuse curl handle?
            $html = $this->getRemoteHtml($url);

            $this->saveTestHtml($html, $url);

            usleep($rate);

            $progress->advance();
        }

        $progress->finish();
    }

    protected function getRemoteHtml($url)
    {
        if (false === $curl = curl_init()) {
            throw new RuntimeException('Unable to create a cURL handle.');
        }

        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt(
            $curl,
            CURLOPT_USERAGENT,
            'Test Data Generator - v0.1 - https://github.com/ssnepenthe/recipe-scraper'
        );

        $response = curl_exec($curl);

        if (false === $response) {
            $error = curl_error($curl);

            curl_close($curl);

            throw new RuntimeException(sprintf(
                'cURL Error: %s - %s',
                $url,
                $error
            ));
        }

        $headers_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $headers_size);
        $body = substr($response, $headers_size);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if (200 !== $status_code) {
            // We are not following redirects...
            throw new RuntimeException(sprintf(
                'Error (%s - HTTP %s)',
                $url,
                $status_code
            ));
        }

        return $body;
    }

    protected function saveTestHtml($html, $url)
    {
        $file = $this->getHtmlDataFilePathFromUrl($url);
        $dir = pathinfo($file, PATHINFO_DIRNAME);

        if (! is_dir($dir)) {
            mkdir($dir);
        }

        file_put_contents($file, $html);
    }

    protected function getMissingTestUrls()
    {
        return array_filter($this->getTestUrls(), function ($url) {
            return ! file_exists($this->getHtmlDataFilePathFromUrl($url));
        });
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

    protected static function includeFile($file)
    {
        return include $file;
    }
}

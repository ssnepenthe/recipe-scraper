<?php

namespace RecipeScraperTests\Commands;

use RecipeScraperTests\UsesTestData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HtmlGetCommand extends Command
{
    use UsesTestData;

    protected function configure()
    {
        $this->setName('html:get')
            ->setDescription('Retrieve and save the HTML for a given URL')
            ->addArgument('url', InputArgument::REQUIRED, 'The URL to get');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $html = $this->getRemoteHtml($url);
        $file = $this->getHtmlDataFilePathFromUrl($url);
        $dir = pathinfo($file, PATHINFO_DIRNAME);

        if (! is_dir($dir)) {
            // Recursive?
            mkdir($dir);
        }

        file_put_contents($file, $html);
    }

    protected function getRemoteHtml($url)
    {
        if (false === $curl = curl_init()) {
            throw new \RuntimeException('Unable to create a cURL handle.');
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

            throw new \RuntimeException(sprintf('cURL Error: %s - %s', $url, $error));
        }

        $headers_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $headers_size);
        $body = substr($response, $headers_size);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if (200 !== $status_code) {
            // We are not following redirects...
            throw new \RuntimeException(sprintf('Error (%s - HTTP %s)', $url, $status_code));
        }

        return $body;
    }
}

<?php

namespace RecipeScraperTests\Commands;

use RecipeScraperTests\UsesTestData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StubResultsCommand extends Command
{
    use UsesTestData;

    protected function configure()
    {
        $this->setName('stub-results')
            ->setDescription('Ensure results files exist for all HTML data files');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $urls = $this->getMissingResultsUrls();

        $progress = new ProgressBar($output, count($urls));
        $progress->start();

        foreach ($urls as $url) {
            $this->saveTestResultsStub($url);

            $progress->advance();
        }

        $progress->finish();
    }

    protected function saveTestResultsStub($url)
    {
        $file = $this->getResultsDataFilePathFromUrl($url);
        $dir = pathinfo($file, PATHINFO_DIRNAME);

        if (! is_dir($dir)) {
            mkdir($dir);
        }

        copy($this->getDataFilePath('stub', 'results'), $file);
    }

    protected function getMissingResultsUrls()
    {
        return array_filter($this->getTestUrls(), function ($url) {
            return ! file_exists($this->getResultsDataFilePathFromUrl($url));
        });
    }
}

<?php

namespace RecipeScraperTests\Commands;

use RecipeScraperTests\UsesTestData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResultsCleanupCommand extends Command
{
    use UsesTestData;

    protected function configure()
    {
        $this->setName('results:cleanup')
            ->setDescription('Delete results files for which there is no corresponding test URL');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Do exist.
        $files = $this->getResultsFilesList();

        // Should exist.
        $urlFiles = array_map(function ($url) {
            return $this->getResultsDataFilePathFromUrl($url);
        }, $this->getTestUrls());

        // Do exist but shouldn't.
        $missing = array_diff($files, $urlFiles);

        foreach ($missing as $file) {
            // @todo Some sort of feedback?
            unlink($file);
        }
    }
}

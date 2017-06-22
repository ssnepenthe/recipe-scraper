<?php

namespace RecipeScraperTests;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HtmlCleanupCommand extends Command
{
    use UsesTestData;

    protected function configure()
    {
        $this->setName('html:cleanup')
            ->setDescription('Delete test HTML for which there is no corresponding test URL');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Do exist.
        $files = $this->getHtmlFilesList();

        // Should exist.
        $urlFiles = array_map(function ($url) {
            return $this->getHtmlDataFilePathFromUrl($url);
        }, $this->getTestUrls());

        // Do exist but shouldn't.
        $missing = array_diff($files, $urlFiles);

        foreach ($missing as $file) {
            // @todo Some sort of feedback?
            unlink($file);
        }
    }
}

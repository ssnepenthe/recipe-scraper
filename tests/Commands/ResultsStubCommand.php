<?php

namespace RecipeScraperTests\Commands;

use RecipeScraperTests\UsesTestData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResultsStubCommand extends Command
{
    use UsesTestData;

    protected function configure()
    {
        $this->setName('results:stub')
            ->setDescription('Create a results test stub for a given URL')
            ->addArgument('url', InputArgument::REQUIRED, 'The URL to generate a stub for');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $file = $this->getResultsDataFilePathFromUrl($url);

        if (file_exists($file)) {
            // @todo Prompt user to allow overwriting file?
            (new SymfonyStyle($input, $output))->error(sprintf(
                'Results file [%s] for provided URL [%s] already exists',
                $file,
                $url
            ));
            return 1;
        }

        $dir = pathinfo($file, PATHINFO_DIRNAME);

        if (! is_dir($dir)) {
            // Recursive?
            mkdir($dir);
        }

        // @todo Some sort of feedback?
        copy($this->getDataFilePath('stub', 'results'), $file);
    }
}

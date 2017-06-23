<?php

namespace RecipeScraperTests\Commands;

use RecipeScraperTests\UsesTestData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResultsStubAllCommand extends Command
{
    use UsesTestData;

    protected function configure()
    {
        $this->setName('results:stub-all')
            ->setDescription('Create results test stubs for all test URLs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get test URLs, convert to results filepaths and filter out files that already exist.
        $files = array_filter(
            array_map(function ($url) {
                return [
                    'file' => $this->getResultsDataFilePathFromUrl($url),
                    'url' => $url,
                ];
            }, $this->getTestUrls()),
            function ($fileInfo) {
                return ! file_exists($fileInfo['file']);
            }
        );

        $io = new SymfonyStyle($input, $output);

        // @todo Add force flag (or similar) to allow user to overwrite existing results?
        if (! $count = count($files)) {
            $io->success('Results files already exist for all test URLs');
            return 0;
        }

        $io->progressStart($count);

        $resultsStubCommand = $this->getApplication()->find('results:stub');

        foreach ($files as $fileInfo) {
            $resultsStubInput = new ArrayInput(['url' => $fileInfo['url']]);

            // @todo Error handling base on return code?
            $returnCode = $resultsStubCommand->run($resultsStubInput, $output);

            $io->progressAdvance();
        }

        $io->progressFinish();
    }
}

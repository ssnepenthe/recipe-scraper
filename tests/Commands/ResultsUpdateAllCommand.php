<?php

namespace RecipeScraperTests\Commands;

use InvalidArgumentException;
use RecipeScraper\Factory;
use RecipeScraperTests\UsesTestData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\VarExporter\VarExporter;

class ResultsUpdateAllCommand extends Command
{
    use UsesTestData;

    protected function configure()
    {
        $this->setName('results:update-all')
            ->setDescription('Update all result files with content from their corresponding HTML file')
            ->addArgument(
                'fields',
                InputArgument::REQUIRED,
                'A comma separated list of result fields to update'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $urls = $this->getTestUrls();
        shuffle($urls);

        $io = new SymfonyStyle($input, $output);

        $io->progressStart(count($urls));

        $htmlGetCommand = $this->getApplication()->find('result:update');

        $fieldsStr = $input->getArgument('fields');
        $fields = explode(',', $fieldsStr);
        // @todo check if fields match with stub fields


        foreach ($urls as $url) {
            $arguments = ['fields' => $fields];
            $resultUpdateInput = new ArrayInput($arguments);

            // @todo Error handling base on return code?
            $returnCode = $htmlGetCommand->run($resultUpdateInput, $output);

            $io->progressAdvance();
        }

        $io->progressFinish();
    }
}

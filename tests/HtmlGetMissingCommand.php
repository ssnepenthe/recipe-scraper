<?php

namespace RecipeScraperTests;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HtmlGetMissingCommand extends Command
{
    use UsesTestData;

    protected function configure()
    {
        $this->setName('html:get-missing')
            ->setDescription('Retrieve and save the HTML for all tested URLs that are missing')
            ->addOption(
                'rate',
                null,
                InputOption::VALUE_OPTIONAL,
                'Seconds to wait between requests',
                1
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rate = intval(round(max(0.0, floatval($input->getOption('rate'))) * 1000000));

        $urls = array_filter($this->getTestUrls(), function ($url) {
            return ! file_exists($this->getHtmlDataFilePathFromUrl($url));
        });
        shuffle($urls);

        $io = new SymfonyStyle($input, $output);

        if (! $count = count($urls)) {
            $io->success('HTML already exists for all test URLs');
            return 0;
        }

        $io->progressStart($count);

        $htmlGetCommand = $this->getApplication()->find('html:get');

        foreach ($urls as $url) {
            $arguments = ['url' => $url];
            $htmlGetInput = new ArrayInput($arguments);

            // @todo Error handling base on return code?
            $returnCode = $htmlGetCommand->run($htmlGetInput, $output);

            usleep($rate);

            $io->progressAdvance();
        }

        $io->progressFinish();
    }
}

<?php

namespace RecipeScraperTests;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HtmlGetAllCommand extends Command
{
    use UsesTestData;

    protected function configure()
    {
        $this->setName('html:get-all')
            ->setDescription('Retrieve and save the HTML for all tested URLs')
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

        $urls = $this->getTestUrls();
        shuffle($urls);

        $io = new SymfonyStyle($input, $output);

        $io->progressStart(count($urls));

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

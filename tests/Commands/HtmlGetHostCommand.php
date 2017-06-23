<?php

namespace RecipeScraperTests\Commands;

use RecipeScraperTests\UsesTestData;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HtmlGetHostCommand extends Command
{
    use UsesTestData;

    protected function configure()
    {
        $this->setName('html:get-host')
            ->setDescription('Retrieve and save the HTML for all tested URLs of a given host')
            ->addArgument('host', InputArgument::REQUIRED, 'The host to get HTML for')
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
        $host = $input->getArgument('host');
        $rate = intval(round(max(0.0, floatval($input->getOption('rate'))) * 1000000));

        $file = $this->getUrlsDataFilePath($host);

        if (! file_exists($file)) {
            throw new \InvalidArgumentException(sprintf(
                'URLs file [%s] for provided host [%s] does not exist',
                $file,
                $host
            ));
        }

        $urls = (array) static::includeFile($file);
        $htmlGetCommand = $this->getApplication()->find('html:get');

        if (empty($urls)) {
            throw new \InvalidArgumentException(sprintf(
                'URLs file [%s] for provided host [%s] is empty',
                $file,
                $host
            ));
        }

        $io = new SymfonyStyle($input, $output);
        $io->progressStart(count($urls));

        foreach ($urls as $url) {
            $htmlGetInput = new ArrayInput(['url' => $url]);

            // @todo Error handling base on return code?
            $returnCode = $htmlGetCommand->run($htmlGetInput, $output);

            usleep($rate);

            $io->progressAdvance();
        }

        $io->progressFinish();
    }
}

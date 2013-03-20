<?php

namespace Liuggio\StatsDClientBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to send a timing metric to statsd
 *
 * @author Pablo Godel <pgodel@gmail.com>
 */
class TimingCommand extends BaseCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('statsd:timing')
            ->setDescription('Sends a timing metric to StatsD')
            ->addArgument('key', InputArgument::REQUIRED, 'The key')
            ->addArgument('value', InputArgument::REQUIRED, 'The value')
            ->setHelp(<<<EOT
The <info>%command.full_name%</info> command sends a timing metric to StatsD:

  <info>./app/console %command.full_name%</info>

EOT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = $this->getDataFactory()->timing(
            $input->getArgument('key'),
            $input->getArgument('value')
        );
        $this->getClientService()->send($data);
    }
}
<?php

namespace Liuggio\StatsDClientBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to send an set metric to statsd
 *
 * @author Pablo Godel <pgodel@gmail.com>
 */
class SetCommand extends BaseCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('statsd:set')
            ->setDescription('Sends a set metric to StatsD')
            ->addArgument('key', InputArgument::REQUIRED, 'The key')
            ->addArgument('value', InputArgument::REQUIRED, 'The value')
            ->setHelp(<<<EOT
The <info>%command.full_name%</info> command sends a set metric to StatsD:

  <info>./app/console %command.full_name%</info>

EOT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = $this->getDataFactory()->set(
            $input->getArgument('key'),
            $input->getArgument('value')
        );
        $this->getClientService()->send($data);
    }
}
<?php

namespace Liuggio\StatsDClientBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class BaseCommand extends ContainerAwareCommand
{
    protected function getDataFactory()
    {
        return $this->getContainer()->get('liuggio_stats_d_client.factory');
    }

    protected function getClientService()
    {
        return $this->getContainer()->get('liuggio_stats_d_client.service');
    }
}

<?php

namespace Liuggio\StatsDClientBundle;

use Liuggio\StatsDClientBundle\DependencyInjection\Compiler\DataCollectorCompilerPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\HttpFoundation\Request;

class LiuggioStatsDClientBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new DataCollectorCompilerPass());
    }

}

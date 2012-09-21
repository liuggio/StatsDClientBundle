<?php

namespace Liuggio\StatsDClientBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\Scope;
use Symfony\Component\HttpFoundation\Request;


use Liuggio\StatsDClientBundle\DependencyInjection\Compiler\CollectorCompilerPass;

class LiuggioStatsDClientBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new CollectorCompilerPass());
    }

}

<?php

namespace IWF\ClockProviderBundle;

use IWF\ClockProviderBundle\DependencyInjection\Compiler\TimestampableClockPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ClockProviderBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new TimestampableClockPass());
    }
}
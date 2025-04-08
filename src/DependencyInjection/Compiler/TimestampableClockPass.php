<?php

namespace IWF\ClockProviderBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TimestampableClockPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if ($container->getParameter('iwf.clock_provider.enabled') == true)
        {
            if ($container->has('gedmo.listener.timestampable')) {
                $definition = $container->findDefinition('gedmo.listener.timestampable');
            } elseif ($container->has('stof_doctrine_extensions.listener.timestampable')) {
                $definition = $container->findDefinition('stof_doctrine_extensions.listener.timestampable');
            } else {
                return;
            }
            $definition->addMethodCall('setClock', [new Reference('Symfony\Component\Clock\MockClock')]);
        }
    }
}
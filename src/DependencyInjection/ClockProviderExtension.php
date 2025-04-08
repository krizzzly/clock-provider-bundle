<?php

namespace IWF\ClockProviderBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ClockProviderExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('services.yaml');

        $container->setParameter('iwf.clock_provider.session_key', $config['session_key']);
        $container->setParameter('iwf.clock_provider.query_param', $config['query_param']);
        $container->setParameter('iwf.clock_provider.env_var_name', $config['env_var_name']);

        // Check if time warp is enabled from env var
        $envVarValue = isset($_ENV[$config['env_var_name']]) ? $_ENV[$config['env_var_name']] : 'false';
        $enabled = in_array(strtolower($envVarValue), ['true', '1', 'yes', 'on'], true);

        $container->setParameter('iwf.clock_provider.enabled', $enabled);

        // Only register the mock clock service if time warp is enabled
        if ($enabled) {
            $loader->load('mock_clock_services.yaml');
        }

    }

    public function getAlias(): string
    {
        return 'clock_provider';
    }
}
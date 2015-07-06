<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\SimpleBundlePlugin;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ASimplePlugin extends SimpleBundlePlugin
{
    public function name()
    {
        return 'a_simple_plugin';
    }

    public function load(array $pluginConfiguration, ContainerBuilder $container)
    {
        $container->setParameter('a_simple_plugin.loaded', true);
    }
}

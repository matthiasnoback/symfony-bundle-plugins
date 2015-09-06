<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\SimpleBundlePlugin;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class ASimplePluginWithPrependExtension extends SimpleBundlePlugin implements PrependExtensionInterface
{
    public function name()
    {
        return 'a_simple_plugin_with_prepend_extension';
    }

    public function load(array $pluginConfiguration, ContainerBuilder $container)
    {
        $container->setParameter('a_simple_plugin_with_prepend_extension.loaded', true);
    }

    public function prepend(ContainerBuilder $container)
    {
        $container->setParameter('a_simple_plugin_with_prepend_extension.prepend_method_called', true);
    }
}

<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\BundlePlugin;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class FooPlugin implements BundlePlugin
{
    public static $booted;
    public static $built;

    public function name()
    {
        return 'foo';
    }

    public function load(array $pluginConfiguration, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('foo.yml');
    }

    public function addConfiguration(ArrayNodeDefinition $pluginNode)
    {
        $pluginNode
            ->children()
                ->scalarNode('foo')
                ->isRequired()
            ->end();
    }

    public function build(ContainerBuilder $container)
    {
        self::$built = true;
    }

    public function boot(ContainerInterface $container)
    {
        self::$booted = true;
    }
}

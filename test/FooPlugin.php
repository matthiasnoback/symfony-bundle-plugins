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
        $container->addCompilerPass(new SetParameterCompilerPass('foo.build_was_called', true));
    }

    public function boot(ContainerInterface $container)
    {
        $container->get('foo.boot')->call();
    }
}

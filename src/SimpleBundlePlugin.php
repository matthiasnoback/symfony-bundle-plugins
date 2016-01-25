<?php

namespace Matthias\BundlePlugins;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Extend this class instead of implementing `BundlePlugin` if your plugin is pretty simple and doesn't need
 */
abstract class SimpleBundlePlugin implements BundlePlugin
{
    /**
     * Override this method if your plugin needs its own configuration nodes.
     *
     * @inheritdoc
     */
    public function addConfiguration(ArrayNodeDefinition $pluginNode)
    {
    }

    /**
     * Override this method if your plugin needs to register compiler passes.
     *
     * @inheritdoc
     */
    public function build(ContainerBuilder $container)
    {
    }

    /**
     * Override this method if your plugin needs to do any kind of runtime initialization.
     *
     * @inheritdoc
     */
    public function boot(ContainerInterface $container)
    {
    }

    /**
     * Override this method if your plugin needs to prepend configuration
     *
     * @inheritdoc
     */
    public function prepend(ContainerBuilder $container)
    {
    }
}

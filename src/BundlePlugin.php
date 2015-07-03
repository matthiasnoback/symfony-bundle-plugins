<?php

namespace Matthias\BundlePlugins;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

interface BundlePlugin
{
    /**
     * The name of this plugin. It will be used as the configuration key.
     *
     * @return string
     */
    public function name();

    /**
     * Load this plugin: define services, load service definition files, etc.
     *
     * @param array $pluginConfiguration The part of the bundle configuration for this plugin
     * @param ContainerBuilder $container
     * @return void
     */
    public function load(array $pluginConfiguration, ContainerBuilder $container);

    /**
     * Add configuration nodes for this plugin to the provided node, e.g.:
     *     $pluginNode
     *         ->children()
     *             ->scalarNode('foo')
     *                 ->isRequired()
     *             ->end()
     *         ->end();
     *
     * @param ArrayNodeDefinition $pluginNode
     * @return void
     */
    public function addConfiguration(ArrayNodeDefinition $pluginNode);

    /**
     * When the container is generated for the first time, you can register compiler passes inside this method.
     *
     * @see BundleInterface::build()
     * @param ContainerBuilder $container
     * @return void
     */
    public function build(ContainerBuilder $container);

    /**
     * When the bundles are booted, you can do any runtime initialization required inside this method.
     *
     * @see BundleInterface::boot()
     * @param ContainerInterface $container
     * @return void
     */
    public function boot(ContainerInterface $container);
}

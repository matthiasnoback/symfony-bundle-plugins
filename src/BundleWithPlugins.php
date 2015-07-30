<?php

namespace Matthias\BundlePlugins;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Extend your bundle from this class. It allows users to register plugins for this bundle by providing them as
 * constructor arguments.
 *
 * The bundle itself can have no container extension or configuration anymore. Instead, you can introduce something
 * like a `CorePlugin`, which is registered as a `BundlePlugin` for this bundle. Return an instance of it from your
 * bundle's `defaultPlugins()` method.
 */
abstract class BundleWithPlugins extends Bundle
{
    /**
     * @var BundlePlugin[]
     */
    private $registeredPlugins = array();

    abstract public function getAlias();

    public function addConfiguration(NodeDefinition $rootNode)
    {
    }

    final public function __construct(array $plugins = array())
    {
        foreach ($this->defaultPlugins() as $plugin) {
            $this->registerPlugin($plugin);
        }

        foreach ($plugins as $plugin) {
            $this->registerPlugin($plugin);
        }
    }

    /**
     * @inheritdoc
     */
    final public function build(ContainerBuilder $container)
    {
        foreach ($this->registeredPlugins as $plugin) {
            $plugin->build($container);
        }
    }

    /**
     * @inheritdoc
     */
    final public function boot()
    {
        foreach ($this->registeredPlugins as $plugin) {
            $plugin->boot($this->container);
        }
    }

    /**
     * Provide any number of `BundlePlugin`s that should always be registered.
     *
     * @return BundlePlugin[]
     */
    protected function defaultPlugins()
    {
        return array();
    }

    /**
     * @inheritdoc
     */
    final public function getContainerExtension()
    {
        return new ExtensionWithPlugins($this);
    }

    /**
     * Register a plugin for this bundle.
     *
     * @param BundlePlugin $plugin
     */
    private function registerPlugin(BundlePlugin $plugin)
    {
        $this->registeredPlugins[] = $plugin;
    }

    public function getPlugins()
    {
        return $this->registeredPlugins;
    }
}

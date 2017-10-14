<?php

namespace Matthias\BundlePlugins;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ExtensionWithPlugins extends Extension implements PrependExtensionInterface
{
    /**
     * @var string
     */
    private $alias;

    /**
     * @var BundlePlugin[]
     */
    private $registeredPlugins;

    /**
     * @param string $alias The alias for this extension (i.e. the configuration key)
     * @param array $registeredPlugins The plugins that were registered
     */
    public function __construct($alias, array $registeredPlugins)
    {
        $this->registeredPlugins = $registeredPlugins;
        $this->alias = $alias;
    }

    /**
     * @inheritdoc
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($config, $container);

        $processedConfiguration = $this->processConfiguration($configuration, $config);

        foreach ($this->registeredPlugins as $plugin) {
            $this->loadPlugin($container, $plugin, $processedConfiguration);
        }
    }

    /**
     * @inheritdoc
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new ConfigurationWithPlugins($this->getAlias(), $this->registeredPlugins);
    }

    /**
     * @inheritdoc
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @inheritdoc
     */
    public function prepend(ContainerBuilder $container)
    {
        foreach ($this->registeredPlugins as $plugin) {
            if ($plugin instanceof PrependExtensionInterface) {
                $plugin->prepend($container);
            }
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param BundlePlugin $plugin
     * @param array $processedConfiguration The fully processed configuration values for this bundle
     */
    private function loadPlugin(ContainerBuilder $container, BundlePlugin $plugin, array $processedConfiguration)
    {
        $container->addClassResource(new \ReflectionClass(get_class($plugin)));

        $pluginConfiguration = $this->pluginConfiguration($plugin, $processedConfiguration);

        $plugin->load($pluginConfiguration, $container);
    }

    /**
     * Get just the part of the configuration values that applies to the given plugin.
     *
     * @param BundlePlugin $plugin
     * @param array $processedConfiguration The fully processed configuration values for this bundle
     * @return array
     */
    private function pluginConfiguration(BundlePlugin $plugin, array $processedConfiguration)
    {
        if (!isset($processedConfiguration[$plugin->name()])) {
            return array();
        }

        return $processedConfiguration[$plugin->name()];
    }
}

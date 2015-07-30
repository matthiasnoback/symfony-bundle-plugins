<?php

namespace Matthias\BundlePlugins;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class ExtensionWithPlugins extends Extension
{
    /**
     * @var BundleWithPlugins
     */
    private $bundle;

    /**
     * @param BundleWithPlugins $bundle
     */
    public function __construct(BundleWithPlugins $bundle)
    {
        $this->bundle = $bundle;
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
        return new ConfigurationWithPlugins($this->bundle);
    }

    /**
     * @inheritdoc
     */
    public function getAlias()
    {
        return $this->bundle->getAlias();
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

<?php

namespace Matthias\BundlePlugins;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class ConfigurationWithPlugins implements ConfigurationInterface
{
    /**
     * @var string
     */
    private $bundle;

    /**
     * @param string $rootNodeName
     * @param array $registeredPlugins
     */
    public function __construct(BundleWithPlugins $bundle)
    {
        $this->bundle = $bundle;
    }

    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->bundle->getAlias());
        $bundleNode = $this->bundle->addConfiguration($rootNode);

        foreach ($this->bundle->getPlugins() as $plugin) {
            $pluginNode = $rootNode->children()->arrayNode($plugin->name());
            $plugin->addConfiguration($pluginNode);
        }

        return $treeBuilder;
    }
}

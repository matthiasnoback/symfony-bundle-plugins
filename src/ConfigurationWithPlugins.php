<?php

namespace Matthias\BundlePlugins;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ConfigurationWithPlugins implements ConfigurationInterface
{
    /**
     * @var string
     */
    private $rootNodeName;

    /**
     * @var BundlePlugin[]
     */
    private $registeredPlugins;

    /**
     * @param string $rootNodeName
     * @param array $registeredPlugins
     */
    public function __construct($rootNodeName, array $registeredPlugins)
    {
        $this->registeredPlugins = $registeredPlugins;
        $this->rootNodeName = $rootNodeName;
    }

    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->rootNodeName);

        foreach ($this->registeredPlugins as $plugin) {
            $pluginNode = $rootNode->children()->arrayNode($plugin->name());
            $plugin->addConfiguration($pluginNode);
        }

        return $treeBuilder;
    }
}

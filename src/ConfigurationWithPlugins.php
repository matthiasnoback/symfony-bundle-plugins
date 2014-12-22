<?php

namespace Matthias\BundlePlugins;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ConfigurationWithPlugins implements ConfigurationInterface
{
    private $root;

    /**
     * @var BundlePlugin[]
     */
    private $plugins;

    public function __construct($root, array $plugins)
    {
        $this->plugins = $plugins;
        $this->root = $root;
    }

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->root);

        foreach ($this->plugins as $plugin) {
            $pluginNode = $rootNode->children()->arrayNode($plugin->name());
            $plugin->addConfiguration($pluginNode);
        }

        return $treeBuilder;
    }
}

<?php

namespace Matthias\BundlePlugins;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

interface BundlePlugin
{
    public function name();

    public function load(array $pluginConfiguration, ContainerBuilder $container);

    public function addConfiguration(ArrayNodeDefinition $pluginNode);
}

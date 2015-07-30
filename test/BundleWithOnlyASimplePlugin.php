<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\BundleWithPlugins;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

class BundleWithOnlyASimplePlugin extends BundleWithPlugins
{
    public function getAlias()
    {
        return 'bundle_with_only_a_simple_plugin';
    }

    protected function defaultPlugins()
    {
        return array(
            new ASimplePlugin()
        );
    }
}

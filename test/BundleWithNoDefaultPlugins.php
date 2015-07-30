<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\BundleWithPlugins;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

class BundleWithNoDefaultPlugins extends BundleWithPlugins
{
    public function getAlias()
    {
        return 'bundle_with_no_default_plugins';
    }
}

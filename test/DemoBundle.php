<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\BundleWithPlugins;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;

class DemoBundle extends BundleWithPlugins
{
    public function getAlias()
    {
        return 'demo';
    }

    protected function defaultPlugins()
    {
        return array(new CorePlugin());
    }
}

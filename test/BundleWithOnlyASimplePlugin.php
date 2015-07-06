<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\BundleWithPlugins;

class BundleWithOnlyASimplePlugin extends BundleWithPlugins
{
    protected function getAlias()
    {
        return 'bundle_with_only_a_simple_plugin';
    }

    protected function alwaysRegisteredPlugins()
    {
        return array(
            new ASimplePlugin()
        );
    }
}

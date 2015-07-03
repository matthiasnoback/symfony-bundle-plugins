<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\BundleWithPlugins;

class DemoBundle extends BundleWithPlugins
{
    protected function getAlias()
    {
        return 'demo';
    }

    protected function alwaysRegisteredPlugins()
    {
        return array(new CorePlugin());
    }
}

<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\BundleWithPlugins;

class BundleWithNoDefaultPlugins extends BundleWithPlugins
{
    protected function getAlias()
    {
        return 'bundle_with_no_default_plugins';
    }
}

<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\BundleWithPlugins;

class DemoBundle extends BundleWithPlugins
{
    protected function getAlias()
    {
        return 'demo';
    }

    public function __construct(array $plugins = array())
    {
        parent::__construct(
            array_merge(
                array(new CorePlugin()),
                $plugins
            )
        );
    }
}

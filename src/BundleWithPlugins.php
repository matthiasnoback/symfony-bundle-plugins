<?php

namespace Matthias\BundlePlugins;

use Symfony\Component\HttpKernel\Bundle\Bundle;

abstract class BundleWithPlugins extends Bundle
{
    private $plugins = array();

    abstract protected function getAlias();

    public function __construct(array $plugins = array())
    {
        foreach ($plugins as $plugin) {
            $this->addPlugin($plugin);
        }
    }

    private function addPlugin(BundlePlugin $plugin)
    {
        $this->plugins[] = $plugin;
    }

    public function getContainerExtension()
    {
        return new ExtensionWithPlugins($this->getAlias(), $this->plugins);
    }
}

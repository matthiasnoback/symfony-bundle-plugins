<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\BundlePlugin;
use Symfony\Component\HttpKernel\Kernel;

class BundleWithPluginsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_only_loads_configuration_for_enabled_bundles_1()
    {
        $kernel = new AppKernel(
            array(),
            array(new FooPlugin())
        );
        $kernel->boot();

        $this->pluginIsLoaded($kernel, new CorePlugin());
        $this->pluginIsLoaded($kernel, new FooPlugin());
    }

    /**
     * @test
     */
    public function it_only_loads_configuration_for_enabled_bundles_2()
    {
        $kernel = new AppKernel(
            array(),
            array(new FooPlugin(), new BarPlugin())
        );
        $kernel->boot();

        $this->pluginIsLoaded($kernel, new CorePlugin());
        $this->pluginIsLoaded($kernel, new FooPlugin());
        $this->pluginIsLoaded($kernel, new BarPlugin());
    }

    private function pluginIsLoaded(Kernel $httpKernel, BundlePlugin $plugin)
    {
        $this->assertTrue($httpKernel->getContainer()->hasParameter($plugin->name() . '.loaded'));
        $this->assertTrue($plugin::$built);
        $this->assertTrue($plugin::$booted);
    }
}

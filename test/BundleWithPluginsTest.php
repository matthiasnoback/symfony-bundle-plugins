<?php

namespace Matthias\BundlePlugins\Tests;

use Symfony\Component\HttpKernel\HttpKernel;
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

        $this->pluginIsLoaded($kernel, 'core');
        $this->pluginIsLoaded($kernel, 'foo');
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

        $this->pluginIsLoaded($kernel, 'core');
        $this->pluginIsLoaded($kernel, 'foo');
        $this->pluginIsLoaded($kernel, 'bar');
    }

    private function pluginIsLoaded(Kernel $httpKernel, $plugin)
    {
        $this->assertTrue($httpKernel->getContainer()->hasParameter($plugin . '.loaded'));
    }
}

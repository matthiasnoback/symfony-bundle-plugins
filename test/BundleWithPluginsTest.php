<?php

namespace Matthias\BundlePlugins\Tests;

use Symfony\Component\HttpKernel\Kernel;

class BundleWithPluginsTest extends IsolatedKernelTestCase
{
    /**
     * @test
     */
    public function it_only_loads_configuration_for_enabled_bundles_1()
    {
        $kernel = $this->createKernel(array(), array(
            new DemoBundle(array(new FooPlugin())),
        ));

        $this->pluginIsLoaded($kernel, 'core');
        $this->pluginIsLoaded($kernel, 'foo');
        $this->pluginIsNotLoaded($kernel, 'bar');
    }

    /**
     * @test
     */
    public function it_only_loads_configuration_for_enabled_bundles_2()
    {
        $kernel = $this->createKernel(array(), array(
            new DemoBundle(array(
                new FooPlugin(),
                new BarPlugin(),
            ))
        ));

        $this->pluginIsLoaded($kernel, 'core');
        $this->pluginIsLoaded($kernel, 'foo');
        $this->pluginIsLoaded($kernel, 'bar');
    }

    /**
     * @test
     */
    public function it_loads_no_plugins_if_there_are_no_default_plugins()
    {
        $kernel = $this->createKernel(array(), array(new BundleWithNoDefaultPlugins()));

        $this->pluginIsNotLoaded($kernel, 'core');
        $this->pluginIsNotLoaded($kernel, 'foo');
        $this->pluginIsNotLoaded($kernel, 'bar');
    }

    /**
     * @test
     */
    public function it_can_load_very_simple_plugins()
    {
        $kernel = $this->createKernel(array(), array(new BundleWithOnlyASimplePlugin()));

        $this->assertTrue($kernel->getContainer()->hasParameter('a_simple_plugin.loaded'));
    }

    /**
     * @param Kernel $kernel
     * @param string $pluginName
     */
    private function pluginIsLoaded(Kernel $kernel, $pluginName)
    {
        $this->pluginIs(true, $kernel, $pluginName);
    }

    /**
     * @param Kernel $kernel
     * @param string $pluginName
     */
    private function pluginIsNotLoaded(Kernel $kernel, $pluginName)
    {
        $this->pluginIs(false, $kernel, $pluginName);
    }

    /**
     * @param bool $loaded
     * @param Kernel $kernel
     * @param string $pluginName
     */
    private function pluginIs($loaded, Kernel $kernel, $pluginName)
    {
        $this->assertSame($loaded, $kernel->getContainer()->hasParameter($pluginName . '.loaded'));
        $this->assertSame($loaded, $kernel->getContainer()->hasParameter($pluginName . '.build_was_called'));

        if ($kernel->getContainer()->has($pluginName . 'boot')) {
            $this->assertSame($loaded, $kernel->getContainer()->get($pluginName . '.boot')->wasCalled());
        }
    }
}

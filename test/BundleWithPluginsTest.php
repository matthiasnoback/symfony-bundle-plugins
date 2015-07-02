<?php

namespace Matthias\BundlePlugins\Tests;

use Matthias\BundlePlugins\BundlePlugin;
use Symfony\Component\HttpKernel\Kernel;

class BundleWithPluginsTest extends IsolatedKernelTestCase
{
    /**
     * @test
     */
    public function it_only_loads_configuration_for_enabled_bundles_1()
    {
        $kernel = $this->createKernel(array(), array(
            new FooPlugin(),
        ));

        $this->pluginIsLoaded($kernel, new CorePlugin());
        $this->pluginIsLoaded($kernel, new FooPlugin());
    }

    /**
     * @test
     */
    public function it_only_loads_configuration_for_enabled_bundles_2()
    {
        $kernel = $this->createKernel(array(), array(
            new FooPlugin(),
            new BarPlugin(),
        ));

        $this->pluginIsLoaded($kernel, new CorePlugin());
        $this->pluginIsLoaded($kernel, new FooPlugin());
        $this->pluginIsLoaded($kernel, new BarPlugin());
    }

    /**
     * @param Kernel $httpKernel
     * @param string $plugin
     */
    private function pluginIsLoaded(Kernel $httpKernel, $plugin)
    {
        $parameterName = $plugin->name() . '.loaded';
        $hasParameter = $httpKernel->getContainer()->hasParameter($parameterName);
        $this->assertTrue($hasParameter, "Failed asserting DI Container has parameter '" . $parameterName . "'");
        $this->assertTrue($plugin::$built);
        $this->assertTrue($plugin::$booted);
    }
}

<?php

namespace Matthias\BundlePlugins\Tests;

class IsolatedKernelTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string Directory with symfony cache
     */
    private $tempDirectory;

    /**
     * Sets a temporary directory for storing symfony cache
     */
    public function setUp()
    {
        parent::setUp();
        $this->tempDirectory = sys_get_temp_dir() . '/' . uniqid('symfony-phpunit');
    }

    /**
     * @param array $configuration
     * @param array $enabledBundles
     *
     * @return AppKernel
     */
    protected function createKernel($configuration, array $enabledBundles)
    {
        $kernel = new AppKernel(
            $configuration,
            $enabledBundles,
            mt_rand(0, 9999999),
            $this->getCacheDir(),
            $this->getLogsDir()
        );
        $kernel->boot();

        return $kernel;
    }

    /**
     * @return string
     */
    private function getCacheDir()
    {
        return $this->tempDirectory . '/cache';
    }

    /**
     * @return string
     */
    private function getLogsDir()
    {
        return $this->tempDirectory . '/logs';
    }

    public function tearDown()
    {
        // TODO: Are we responsible to remove again? Temp dirs get cleaned upon reboot anyway
        // It's not that nice to leave it there, but it's actually symfony doing this...
        parent::tearDown();
    }
}

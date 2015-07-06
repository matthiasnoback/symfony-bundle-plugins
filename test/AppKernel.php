<?php

namespace Matthias\BundlePlugins\Tests;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    private $configuration;
    private $enabledPlugins;

    private $cacheDir;
    private $logsDir;

    public function __construct(array $configuration, array $enabledPlugins, $uniqueIdentifier, $cacheDir, $logsDir)
    {
        parent::__construct('test' . $uniqueIdentifier, true);

        $this->configuration = $configuration;
        $this->enabledPlugins = $enabledPlugins;

        $this->cacheDir = $cacheDir;
        $this->logsDir = $logsDir;
    }


    public function registerBundles()
    {
        return array_merge(
            array(
                new FrameworkBundle(),
                new DemoBundle($this->enabledPlugins)
            )
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yml');

        $configuration = $this->configuration;
        $loader->load(
            function () use ($configuration) {
                return $configuration;
            },
            'closure'
        );
    }

    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    public function getLogDir()
    {
        return $this->logsDir;
    }
}

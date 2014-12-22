<?php

namespace Matthias\BundlePlugins\Tests;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    private $configuration;
    private $enabledPlugins;

    public function __construct(array $configuration, array $enabledPlugins)
    {
        parent::__construct('test', true);

        $this->configuration = $configuration;
        $this->enabledPlugins = $enabledPlugins;
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
        return __DIR__ . '/temp/cache';
    }

    public function getLogDir()
    {
        return __DIR__ . '/temp/logs';
    }
}

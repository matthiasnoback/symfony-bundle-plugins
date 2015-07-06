<?php

namespace Matthias\BundlePlugins\Tests;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SetParameterCompilerPass implements CompilerPassInterface
{
    private $name;
    private $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function process(ContainerBuilder $container)
    {
        $container->setParameter($this->name, $this->value);
    }
}

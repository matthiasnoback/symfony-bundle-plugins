<?php

namespace Matthias\BundlePlugins\Tests;

class BootSpy
{
    private $wasCalled = false;

    public function wasCalled()
    {
        return $this->wasCalled;
    }

    public function call()
    {
        $this->wasCalled = true;
    }
}

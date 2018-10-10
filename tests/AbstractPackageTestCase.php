<?php

namespace RickSelby\Tests;

use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Session\Session;
use GrahamCampbell\TestBench\AbstractPackageTestCase as GrahamAbstractPackageTestCase;
use RickSelby\Laravel\GateCache\GateCacheProvider;

abstract class AbstractPackageTestCase extends GrahamAbstractPackageTestCase
{
    protected function setUp()
    {
        parent::setUp();

        Request::setLaravelSession(app(Session::class));
    }

    protected function getServiceProviderClass($app)
    {
        return GateCacheProvider::class;
    }
}

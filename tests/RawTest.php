<?php

namespace RickSelby\Tests;

use RickSelby\Laravel\GateCache\GateCache;
use PHPUnit\Framework\MockObject\MockObject;

class RawTest extends AbstractPackageTestCase
{
    /** @var MockObject */
    protected $gateMock;

    /** @var GateCache */
    protected $gateCache;

    /** @test */
    public function it_calls_parent_only_once_for_the_same_ability()
    {
        $this->gateCache->expects($this->once())->method('callAuthCallback');

        $this->gateCache->raw('something');
        $this->gateCache->raw('something');
    }

    /** @test */
    public function it_calls_parent_twice_for_different_abilities()
    {
        $this->gateCache->expects($this->exactly(2))->method('callAuthCallback');

        $this->gateCache->raw('something');
        $this->gateCache->raw('somethingelse');
    }

    /** @test */
    public function it_calls_parent_only_once_for_the_same_ability_and_arguments()
    {
        $this->gateCache->expects($this->once())->method('callAuthCallback');

        $this->gateCache->raw('something', ['this']);
        $this->gateCache->raw('something', ['this']);
    }

    /** @test */
    public function it_calls_parent_twice_for_different_arguments()
    {
        $this->gateCache->expects($this->exactly(2))->method('callAuthCallback');

        $this->gateCache->raw('something', ['this']);
        $this->gateCache->raw('something', ['that']);
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->gateCache = $this->getMockBuilder(GateCache::class)
            ->setMethods(['callAuthCallback'])
            ->setConstructorArgs([
                $this->app,
                // User Resolver must return true for 5.6
                function () {
                    return true;
                },
            ])
            ->getMock();
    }
}

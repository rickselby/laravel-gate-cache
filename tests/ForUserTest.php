<?php

namespace RickSelby\Tests;

use RickSelby\Laravel\GateCache\GateCache;
use PHPUnit\Framework\MockObject\MockObject;
use Illuminate\Contracts\Auth\Authenticatable;

class ForUserTest extends AbstractPackageTestCase
{
    /** @var MockObject */
    protected $gateMock;

    /** @var GateCache */
    protected $gateCache;

    /** @var MockObject */
    protected $user;

    /** @test */
    public function we_get_the_same_object_for_the_user()
    {
        $this->assertSame(
            $this->gateCache->forUser($this->user),
            $this->gateCache->forUser($this->user)
        );
    }

    /** @test */
    public function we_get_different_objects_for_different_users()
    {
        $altUser = $this->createMock(Authenticatable::class);
        $altUser->method('getAuthIdentifier')->willReturn(2);

        $this->assertNotSame(
            $this->gateCache->forUser($this->user),
            $this->gateCache->forUser($altUser)
        );
    }

    public function setUp()
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

        $this->user = $this->createMock(Authenticatable::class);
        $this->user->method('getAuthIdentifier')->willReturn(1);
    }
}

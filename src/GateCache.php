<?php

namespace RickSelby\Laravel\GateCache;

use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Container\Container;

class GateCache extends Gate implements GateContract
{
    /** @var \Illuminate\Support\Collection */
    private $rawResults;

    /** @var array */
    private $userInstances = [];

    public function __construct(
        Container $container,
        callable $userResolver,
        array $abilities = [],
        array $policies = [],
        array $beforeCallbacks = [],
        array $afterCallbacks = []
    ) {
        parent::__construct($container, $userResolver, $abilities, $policies, $beforeCallbacks, $afterCallbacks);

        $this->rawResults = collect();
    }

    /**
     * Get the cached raw result from the authorization callback.
     *
     * @param  string  $ability
     * @param  array|mixed  $arguments
     * @return mixed
     */
    public function raw($ability, $arguments = [])
    {
        $hash = $this->getHash($ability, $arguments);

        if (! $this->rawResults->has($hash)) {
            $this->rawResults->put($hash, parent::raw($ability, $arguments));
        }

        return $this->rawResults->get($hash);
    }

    /**
     * Cache each instance of Gate per user...
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|mixed  $user
     * @return Gate|GateContract|mixed
     */
    public function forUser($user)
    {
        if (! isset($this->userInstances[$user->getAuthIdentifier()])) {
            $this->userInstances[$user->getAuthIdentifier()] = parent::forUser($user);
        }

        return $this->userInstances[$user->getAuthIdentifier()];
    }

    /**
     * Generate a unique hash for the request.
     *
     * @param $ability
     * @param $arguments
     * @return string
     */
    protected function getHash($ability, $arguments)
    {
        return hash('md5', $ability.json_encode($arguments));
    }
}

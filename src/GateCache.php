<?php

namespace RickSelby\Laravel\GateCache;

use Illuminate\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class GateCache extends Gate implements GateContract
{
    private $rawResults = [];

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

        if (!isset($this->rawResults[$hash])) {
            $this->rawResults[$hash] = parent::raw($ability, $arguments);
        }

        return $this->rawResults[$hash];
    }

    /**
     * Generate a unique hash for the request
     *
     * @param $ability
     * @param $arguments
     *
     * @return string
     */
    protected function getHash($ability, $arguments)
    {
        return hash('md5', $ability.json_encode($arguments));
    }
}

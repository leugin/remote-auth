<?php

namespace  Leugin\RemoteAuth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class HttpGuard implements Guard
{
    use GuardHelpers;

    /**
     * Create a new authentication guard.
     *
     * @param UserProvider $provider
     * @param Request $request
     * @param null $user
     */
    protected Request $request;

    /**
     * Create a new authentication guard.
     *
     * @param UserProvider $provider
     * @param Request $request
     */
    public function __construct(
        UserProvider $provider,
        Request $request
    ) {
        $this->provider = $provider;
        $this->request = $request;

    }

    public function check(): bool
    {
        $token = $this->request->header('authorization');
       $this->user =  $this->provider->retrieveByToken('Bearer', $token);
        return!is_null($this->user);
    }

    public function user()
    {
        return $this->user;
    }

    public function validate(array $credentials = [])
    {
       return $this->provider->validateCredentials($credentials);
    }


}

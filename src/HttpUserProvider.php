<?php

namespace Leugin\RemoteAuth;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Leugin\RemoteAuth\Dto\Configuration;

class HttpUserProvider implements UserProvider
{

    public function __construct(
        private readonly Configuration $configuration
    )
    {
    }
    public function retrieveById($identifier)
    {
        /**@var Model $model*/
        $model = new $this->configuration->model;

        return $model->newQuery()->find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {

        $response = $this->getRequest($token)
            ->get($this->configuration->me);

        if ($response->successful()) {
            $data = $response->json();
            $id  =  (isset($data) && $data['data'] && $data['data']['id']) ? $data['data']['id'] : null;
            return $id ? $this->retrieveById($id) : null;

        }

        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // TODO: Implement updateRememberToken() method.
    }

    public function retrieveByCredentials(array $credentials): Model|Collection|Builder|Authenticatable|array|null
    {
        $response = $this->getRequest()->post($this->configuration->login, $credentials);
        $id  =  ($response->successful() && isset($data) && $data['data'] && $data['data']['id']) ? $data['data']['id'] : null;
        return $id ? $this->retrieveById($id) : null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return !!$this->retrieveByCredentials($credentials);
    }

    /**
     * @param string|null $authorization
     * @return PendingRequest
     */
    public function getRequest(?string $authorization = null):PendingRequest
    {
        $http = Http::timeout($this->configuration->timeout ?? 100);
        if ($authorization)
            $http->withHeader('authorization', $authorization);
        return $http;
    }


    public static function fake(Authenticatable $user): void
    {
        $faker =   new TestHttpUserProvider($user);
        Auth::provider('http', fn()=> $faker);

    }
}
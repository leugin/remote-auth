<?php

namespace Leugin\RemoteAuth;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class TestHttpUserProvider implements UserProvider
{

    public function __construct(
        private Authenticatable $model
    )
    {
    }
    public function retrieveById($identifier)
    {

        return $this->model;
    }

    public function retrieveByToken($identifier, $token)
    {
        return $this->model;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // TODO: Implement updateRememberToken() method.
    }

    public function retrieveByCredentials(array $credentials): Model|Collection|Builder|Authenticatable|array|null
    {
         return $this->model;
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return  $this->model->getAuthIdentifier() === $user->getAuthIdentifier();
    }


}
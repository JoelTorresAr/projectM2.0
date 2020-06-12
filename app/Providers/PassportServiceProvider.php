<?php

namespace App\Providers;

use App\TokenGuard;
use Illuminate\Auth\RequestGuard;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\ApiTokenCookieFactory;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;

class PassportServiceProvider extends \Laravel\Passport\PassportServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->bind(ApiTokenCookieFactory::class, \App\ApiTokenCookieFactory::class);
    }

    /**
     * Make an instance of the token guard.
     *
     * @param  array  $config
     * @return \Illuminate\Auth\RequestGuard
     */
    protected function makeGuard(array $config)
    {
        return new RequestGuard(function ($request) use ($config) {
            return (new TokenGuard(
                $this->app->make(ResourceServer::class),
                Auth::createUserProvider($config['provider']),
                $this->app->make(TokenRepository::class),
                $this->app->make(ClientRepository::class),
                $this->app->make('encrypter')
            ))->user($request);
        }, $this->app['request']);
    }
}

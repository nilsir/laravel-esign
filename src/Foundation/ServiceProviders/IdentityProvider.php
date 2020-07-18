<?php

/*
 * This file is part of the nilsir/laravel-esign.
 *
 * (c) nilsir <nilsir@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Nilsir\LaravelEsign\Foundation\ServiceProviders;

use Nilsir\LaravelEsign\Identity;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class IdentityProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['identity'] = function ($pimple) {
            return new Identity\Identity($pimple['access_token']);
        };
    }
}

<?php

/*
 * This file is part of the nilsir/laravel-esign.
 *
 * (c) nilsir <nilsir@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Nilsir\LaravelEsign\Foundation\ServiceProviders;

use Nilsir\LaravelEsign\Account;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AccountProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['account'] = function ($pimple) {
            return new Account\Account($pimple['access_token']);
        };
    }
}

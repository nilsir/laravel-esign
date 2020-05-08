<?php

/*
 * This file is part of the nilsir/laravel-esign.
 *
 * (c) nilsir <nilsir@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Nilsir\LaravelEsign\Foundation\ServiceProviders;

use Nilsir\LaravelEsign\SignFlow;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class SignFlowProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['signflow'] = function ($pimple) {
            return new SignFlow\SignFlow($pimple['access_token']);
        };
    }
}

<?php

/*
 * This file is part of the nilsir/laravel-esign.
 *
 * (c) nilsir <nilsir@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Nilsir\LaravelEsign\Foundation\ServiceProviders;

use Nilsir\LaravelEsign\File;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class FileProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['file'] = function ($pimple) {
            return new File\File($pimple['access_token']);
        };
    }
}

<?php

/*
 * This file is part of the nilsir/laravel-esign.
 *
 * (c) nilsir <nilsir@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Nilsir\LaravelEsign\Foundation\ServiceProviders;

use Nilsir\LaravelEsign\Template;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class TemplateProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['template'] = function ($pimple) {
            return new Template\Template($pimple['access_token']);
        };
    }
}

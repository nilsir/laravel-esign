<?php

/*
 * This file is part of the nilsir/laravel-esign.
 *
 * (c) nilsir <nilsir@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Nilsir\LaravelEsign\File;

use Nilsir\LaravelEsign\Core\AbstractAPI;
use Nilsir\LaravelEsign\Exceptions\HttpException;
use Nilsir\LaravelEsign\Support\Collection;

class File extends AbstractAPI
{
    /**
     * @param $templateId
     * @param $name
     * @param $simpleFormFields
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function createByTemplateId($templateId, $name, $simpleFormFields)
    {
        $url = '/v1/files/createByTemplate';
        $params = [
            'name' => $name,
            'templateId' => $templateId,
            'simpleFormFields' => $simpleFormFields,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }
}

<?php

/*
 * This file is part of the nilsir/laravel-esign.
 *
 * (c) nilsir <nilsir@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Nilsir\LaravelEsign\Template;

use Nilsir\LaravelEsign\Core\AbstractAPI;
use Nilsir\LaravelEsign\Exceptions\HttpException;
use Nilsir\LaravelEsign\Support\Collection;

class Template extends AbstractAPI
{
    /**
     * 创建个人模板印章.
     *
     * @param string $accountId 用户id
     * @param string $alias     印章别名
     * @param string $color     印章颜色
     * @param int    $height    印章高度
     * @param int    $width     印章宽度
     * @param string $type      模板类型
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function createPersonalTemplate($accountId, $alias = '', $color = 'RED', $height = 95, $width = 95, $type = 'SQUARE')
    {
        $url = sprintf('/v1/accounts/%s/seals/personaltemplate', $accountId);
        $params = [
            'alias' => $alias,
            'color' => $color,
            'height' => $height,
            'width' => $width,
            'type' => $type,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 创建机构模板印章.
     *
     * @param string $orgId   机构id
     * @param string $alias   印章别名
     * @param string $color   印章颜色
     * @param int    $height  印章高度
     * @param int    $width   印章宽度
     * @param string $htext   横向文
     * @param string $qtext   下弦文
     * @param string $type    模板类型
     * @param string $central 中心图案类型
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function createOfficialTemplate($orgId, $alias = '', $color = 'RED', $height = 159, $width = 159, $htext = '', $qtext = '', $type = 'TEMPLATE_ROUND', $central = 'STAR')
    {
        $url = sprintf('/v1/organizations/%s/seals/officialtemplate', $orgId);
        $params = [
            'alias' => $alias,
            'color' => $color,
            'height' => $height,
            'width' => $width,
            'htext' => $htext,
            'qtext' => $qtext,
            'type' => $type,
            'central' => $central,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 创建个人/机构图片印章.
     *
     * @param string $accountId       用户id
     * @param string $data            印章数据
     * @param string $alias           印章别名
     * @param int    $height          印章高度
     * @param int    $width           印章宽度
     * @param string $type            印章数据类型 BASE64
     * @param bool   $transparentFlag 是否对图片进行透明化处理
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function createImageTemplate($accountId, $data, $alias = '', $height = 95, $width = 95, $type = 'TEMPLATE_ROUND', $transparentFlag = false)
    {
        $url = sprintf('/v1/accounts/%s/seals/image', $accountId);
        $params = [
            'alias' => $alias,
            'height' => $height,
            'width' => $width,
            'type' => $type,
            'data' => $data,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 查询个人印章.
     *
     * @param string $accountId 用户id
     * @param int    $offset    分页起始位置
     * @param int    $size      单页数量
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function queryPersonalTemplates($accountId, $offset = 0, $size = 10)
    {
        $url = sprintf('/v1/accounts/%s/seals', $accountId);
        $params = [
            'offset' => $offset,
            'size' => $size,
        ];

        return $this->parseJSON('get', [$url, $params]);
    }

    /**
     * 查询机构印章.
     *
     * @param string $orgId  机构id
     * @param int    $offset 分页起始位置
     * @param int    $size   单页数量
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function queryOfficialTemplates($orgId, $offset = 0, $size = 10)
    {
        $url = sprintf('/v1/organizations/%s/seals', $orgId);
        $params = [
            'offset' => $offset,
            'size' => $size,
        ];

        return $this->parseJSON('get', [$url, $params]);
    }

    /**
     * 删除个人印章.
     *
     * @param string $accountId 用户id
     * @param string $sealId    印章id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function deletePersonalTemplate($accountId, $sealId)
    {
        $url = sprintf('/v1/accounts/%s/seals/%s', $accountId, $sealId);
        $params = [];

        return $this->parseJSON('delete', [$url, $params]);
    }

    /**
     * 删除机构印章.
     *
     * @param string $orgId  机构id
     * @param string $sealId 印章id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function deleteOfficialTemplate($orgId, $sealId)
    {
        $url = sprintf('/v1/organizations/%s/seals/%s', $orgId, $sealId);
        $params = [];

        return $this->parseJSON('delete', [$url, $params]);
    }
}

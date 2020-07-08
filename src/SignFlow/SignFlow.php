<?php

/*
 * This file is part of the nilsir/laravel-esign.
 *
 * (c) nilsir <nilsir@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Nilsir\LaravelEsign\SignFlow;

use Nilsir\LaravelEsign\Core\AbstractAPI;
use Nilsir\LaravelEsign\Exceptions\HttpException;
use Nilsir\LaravelEsign\Support\Collection;

class SignFlow extends AbstractAPI
{
    const NOTICE_TYPE_SMS = '1';
    const NOTICE_TYPE_EMAIL = '2';
    const NOTICE_TYPE_NULL = '';

    /**
     * 一步发起签署.
     *
     * @param array $docs        附件信息
     * @param array $flowInfo    抄送人人列表
     * @param array $signers     待签文档信息
     * @param array $attachments 流程基本信息
     * @param array $copiers     签署方信息
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function createFlowOneStep($docs, $flowInfo, $signers, $attachments = [], $copiers = [])
    {
        $url = '/api/v2/signflows/createFlowOneStep';
        $params = compact('docs', 'flowInfo', 'signers');
        $attachments and $params['attachments'] = $attachments;
        $copiers and $params['copiers'] = $copiers;

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 签署流程创建.
     *
     * @param string $businessScene      文件主题
     * @param string $noticeDeveloperUrl 回调通知地址
     * @param bool   $autoArchive        是否自动归档
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function createSignFlow($businessScene, $noticeDeveloperUrl = null, $autoArchive = true)
    {
        $url = '/v1/signflows';
        $params = [
            'autoArchive' => $autoArchive,
            'businessScene' => $businessScene,
            'configInfo' => [
                'noticeDeveloperUrl' => $noticeDeveloperUrl,
            ],
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 流程文档添加.
     *
     * @param string $flowId       流程id
     * @param string $fileId       文档id
     * @param int    $encryption   是否加密
     * @param null   $fileName     文件名称
     * @param null   $filePassword 文档密码
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function addDocuments($flowId, $fileId, $encryption = 0, $fileName = null, $filePassword = null)
    {
        $url = "/v1/signflows/{$flowId}/documents";
        $params = [
            'docs' => [
                ['fileId' => $fileId, 'encryption' => $encryption, 'fileName' => $fileName, 'filePassword' => $filePassword],
            ],
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 添加平台自动盖章签署区.
     *
     * @param string $flowId           流程id
     * @param string $fileId           文件file id
     * @param string $sealId           印章id
     * @param string $posPage          页码信息
     * @param float  $posX             x坐标
     * @param float  $posY             y坐标
     * @param int    $signDateBeanType 是否需要添加签署日期
     * @param array  $signDateBean     签章日期信息
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function addPlatformSign($flowId, $fileId, $sealId, $posPage, $posX, $posY, $signDateBeanType = 0, $signDateBean = null)
    {
        $url = "/v1/signflows/{$flowId}/signfields/platformSign";
        $signFieldOne = [
            'fileId' => $fileId,
            'sealId' => $sealId,
            'posBean' => [
                'posPage' => $posPage,
                'posX' => $posX,
                'posY' => $posY,
            ],
            'signDateBeanType' => $signDateBeanType,
            'signDateBean' => $signDateBean,
        ];

        $params = [
            'signfields' => [
                $signFieldOne,
            ],
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 添加手动盖章签署区.
     *
     * @param string $flowId           流程id
     * @param string $fileId           文件file id
     * @param string $signerAccountId  签署操作人个人账号标识
     * @param string $posPage          页码信息
     * @param float  $posX             x坐标
     * @param float  $posY             y坐标
     * @param int    $signDateBeanType 是否需要添加签署日期
     * @param array  $signDateBean     签章日期信息
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function addHandSign($flowId, $fileId, $signerAccountId, $posPage, $posX, $posY, $signDateBeanType = 0, $signDateBean = null)
    {
        $url = "/v1/signflows/{$flowId}/signfields/handSign";
        $signFieldOne = [
            'fileId' => $fileId,
            'signerAccountId' => $signerAccountId,
            'posBean' => [
                'posPage' => $posPage,
                'posX' => $posX,
                'posY' => $posY,
            ],
            'signDateBeanType' => $signDateBeanType,
            'signDateBean' => $signDateBean,
        ];

        $params = [
            'signfields' => [
                $signFieldOne,
            ],
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 签署流程开启.
     *
     * @param string $flowId 流程id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function startSignFlow($flowId)
    {
        $url = "/v1/signflows/{$flowId}/start";

        return $this->parseJSON('put', [$url]);
    }

    /**
     * 获取签署地址
     *
     * @param string $flowId    流程id
     * @param string $accountId 签署人账号id
     * @param null   $orgId     指定机构id
     * @param int    $urlType   链接类型: 0-签署链接;1-预览链接;默认0
     * @param null   $appScheme app内对接必传
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function getExecuteUrl($flowId, $accountId, $orgId = null, $urlType = 0, $appScheme = null)
    {
        $url = "/v1/signflows/{$flowId}/executeUrl";
        $params = [
            'accountId' => $accountId,
            'organizeId' => $orgId,
            'urlType' => $urlType,
            'appScheme' => $appScheme,
        ];

        return $this->parseJSON('get', [$url, $params]);
    }

    /**
     * 签署流程归档.
     *
     * @param string $flowId 流程id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function archiveSign($flowId)
    {
        $url = sprintf('/v1/signflows/%s/archive', $flowId);

        return $this->parseJSON('put', [$url]);
    }

    /**
     * 流程文档下载.
     *
     * @param string $flowId 流程id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function downloadDocument($flowId)
    {
        $url = sprintf('/v1/signflows/%s/documents', $flowId);

        return $this->parseJSON('get', [$url]);
    }
}

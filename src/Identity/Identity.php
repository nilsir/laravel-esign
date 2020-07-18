<?php

/*
 * This file is part of the nilsir/laravel-esign.
 *
 * (c) nilsir <nilsir@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Nilsir\LaravelEsign\Identity;

use Nilsir\LaravelEsign\Core\AbstractAPI;
use Nilsir\LaravelEsign\Exceptions\HttpException;
use Nilsir\LaravelEsign\Support\Collection;

class Identity extends AbstractAPI
{
    /**
     * @param string $orgId          机构 id
     * @param string $agentAccountId 办理人账号Id
     * @param string $notifyUrl      发起方接收实名认证状态变更通知的地址
     * @param string $redirectUrl    实名结束后页面跳转地址
     * @param string $contextId      发起方业务上下文标识
     * @param string $authType       指定默认认证类型
     * @param bool   $repeatIdentity 是否允许重复实名，默认允许
     * @param bool   $showResultPage 实名完成是否显示结果页,默认显示
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function getOrgIdentityUrl($orgId, $agentAccountId, $notifyUrl = '', $redirectUrl = '', $contextId = '', $authType = '', $repeatIdentity = true, $showResultPage = true)
    {
        $url = sprintf('/v2/identity/auth/web/%s/orgIdentityUrl', $orgId);
        $params = [
            'authType' => $authType,
            'repeatIdentity' => $repeatIdentity,
            'agentAccountId' => $agentAccountId,
            'contextInfo' => [
                'contextId' => $contextId,
                'notifyUrl' => $notifyUrl,
                'redirectUrl' => $redirectUrl,
                'showResultPage' => $showResultPage,
            ],
        ];

        return $this->parseJSON('json', [$url, $params]);
    }
}

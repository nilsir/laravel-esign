<?php

/*
 * This file is part of the nilsir/laravel-esign.
 *
 * (c) nilsir <nilsir@qq.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Nilsir\LaravelEsign\Account;

use Nilsir\LaravelEsign\Core\AbstractAPI;
use Nilsir\LaravelEsign\Exceptions\HttpException;
use Nilsir\LaravelEsign\Support\Collection;

class Account extends AbstractAPI
{
    /**
     * 创建个人账号.
     *
     * @param string $thirdPartyUserId 用户唯一标识
     * @param string $name             姓名
     * @param string $idType           证件类型, 默认: CRED_PSN_CH_IDCARD
     * @param string $idNumber         证件号
     * @param string $mobile           手机号码
     * @param string $email            邮箱地址
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function createPersonalAccount($thirdPartyUserId, $name, $idType, $idNumber, $mobile = null, $email = null)
    {
        $url = '/v1/accounts/createByThirdPartyUserId';
        $params = [
            'thirdPartyUserId' => $thirdPartyUserId,
            'name' => $name,
            'idType' => $idType,
            'idNumber' => $idNumber,
            'mobile' => $mobile,
            'email' => $email,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 个人账户修改(按照账号ID修改).
     *
     * @param string $accountId 个人账号id
     * @param null   $email     联系方式，邮箱地址
     * @param null   $mobile    联系方式，手机号码
     * @param null   $name      姓名，默认不变
     * @param null   $idType    证件类型，默认为身份证
     * @param null   $idNumber  证件号，该字段只有为空才允许修改
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function updatePersonalAccountById($accountId, $mobile = null, $email = null, $name = null, $idType = null, $idNumber = null)
    {
        $url = sprintf('/v1/accounts/%s', $accountId);
        $params = [
            'mobile' => $mobile,
            'email' => $email,
            'name' => $name,
            'idType' => $idType,
            'idNumber' => $idNumber,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 个人账户修改(按照第三方用户ID修改).
     *
     * @param string $thirdPartyUserId 第三方平台的用户唯一标识
     * @param null   $email            联系方式，邮箱地址
     * @param null   $mobile           联系方式，手机号码
     * @param null   $name             姓名，默认不变
     * @param null   $idType           证件类型，默认为身份证
     * @param null   $idNumber         证件号，该字段只有为空才允许修改
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function updatePersonalAccountByThirdId($thirdPartyUserId, $email = null, $mobile = null, $name = null, $idType = null, $idNumber = null)
    {
        $url = sprintf('/v1/accounts/updateByThirdId?thirdPartyUserId=%s', $thirdPartyUserId);
        $params = [
            'mobile' => $mobile,
            'email' => $email,
            'name' => $name,
            'idType' => $idType,
            'idNumber' => $idNumber,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 查询个人账户（按照账户ID查询）.
     *
     * @param string $accountId 个人账号id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function queryPersonalAccountByAccountId($accountId)
    {
        $url = sprintf('/v1/accounts/%s', $accountId);

        return $this->parseJSON('get', [$url]);
    }

    /**
     * 查询个人账户（按照第三方用户ID查询）.
     *
     * @param string $thirdId 第三方平台的用户id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function queryPersonalAccountByThirdId($thirdId)
    {
        $url = '/v1/accounts/getByThirdId';
        $params = [
            'thirdPartyUserId' => $thirdId,
        ];

        return $this->parseJSON('get', [$url, $params]);
    }

    /**
     * 注销个人账户（按照账号ID注销）.
     *
     * @param string $accountId 个人账号id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function deletePersonalAccountById($accountId)
    {
        $url = sprintf('/v1/accounts/%s', $accountId);

        return $this->parseJSON('delete', [$url]);
    }

    /**
     * 注销个人账户（按照第三方用户ID注销）.
     *
     * @param string $thirdPartyUserId 第三方平台的用户id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function deletePersonalAccountByThirdId($thirdPartyUserId)
    {
        $url = sprintf('/v1/accounts/deleteByThirdId?thirdPartyUserId=%s', $thirdPartyUserId);

        return $this->parseJSON('delete', [$url]);
    }

    /**
     * 设置签署密码.
     *
     * @param string $accountId 用户id
     * @param string $password  MD5加密后的密文
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function setSignPwd($accountId, $password)
    {
        $url = sprintf('/v1/accounts/%s/setSignPwd', $accountId);
        $params = [
            'password' => $password,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 机构账号创建.
     *
     * @param string $thirdPartyUserId string 第三方平台标识, 如: 统一信用代码
     * @param string $creatorAccountId string 创建者 accountId
     * @param string $name             string 机构名称
     * @param string $idType           string 证件类型, 默认: CRED_ORG_USCC
     * @param string $idNumber         string 证件号
     * @param null   $orgLegalIdNumber string 企业法人证件号
     * @param null   $orgLegalName     string 企业法人名称
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function createOrganizeAccount($thirdPartyUserId, $creatorAccountId, $name, $idType, $idNumber, $orgLegalIdNumber = null, $orgLegalName = null)
    {
        $url = '/v1/organizations/createByThirdPartyUserId';
        $params = [
            'thirdPartyUserId' => $thirdPartyUserId,
            'creator' => $creatorAccountId,
            'name' => $name,
            'idType' => $idType,
            'idNumber' => $idNumber,
            'orgLegalIdNumber' => $orgLegalIdNumber,
            'orgLegalName' => $orgLegalName,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 机构账号修改（按照账号ID修改）.
     *
     * @param string $orgId            机构账号id
     * @param null   $name             机构名称，默认不变
     * @param null   $idType           证件类型，默认CRED_ORG_USCC
     * @param null   $idNumber         证件号
     * @param null   $orgLegalIdNumber 企业法人证件号
     * @param null   $orgLegalName     企业法人名称
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function updateOrganizeAccountById($orgId, $name = null, $idType = null, $idNumber = null, $orgLegalIdNumber = null, $orgLegalName = null)
    {
        $url = sprintf('/v1/organizations/%s', $orgId);
        $params = [
            'name' => $name,
            'idType' => $idType,
            'idNumber' => $idNumber,
            'orgLegalIdNumber' => $orgLegalIdNumber,
            'orgLegalName' => $orgLegalName,
        ];

        return $this->parseJSON('put', [$url, $params]);
    }

    /**
     * 机构账号修改（按照第三方机构ID修改）.
     *
     * @param string $thirdPartyUserId 第三方平台机构id
     * @param null   $name             机构名称，默认不变
     * @param null   $idType           证件类型，默认CRED_ORG_USCC
     * @param null   $idNumber         证件号
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function updateOrganizeAccountByThirdId($thirdPartyUserId, $name = null, $idType = null, $idNumber = null)
    {
        $url = sprintf('/v1/organizations/updateByThirdId?thirdPartyUserId=%s', $thirdPartyUserId);
        $params = [
            'name' => $name,
            'idType' => $idType,
            'idNumber' => $idNumber,
        ];

        return $this->parseJSON('put', [$url, $params]);
    }

    /**
     * 查询机构账号（按照账号ID查询）.
     *
     * @param string $orgId 机构账号id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function queryOrganizeAccountByOrgId($orgId)
    {
        $url = sprintf('/v1/organizations/%s', $orgId);

        return $this->parseJSON('get', [$url]);
    }

    /**
     * 查询机构账号（按照第三方机构ID查询）.
     *
     * @param string $thirdPartyUserId 第三方平台机构id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function queryOrganizeAccountByThirdId($thirdPartyUserId)
    {
        $url = sprintf('/v1/organizations/getByThirdId?thirdPartyUserId=%s', $thirdPartyUserId);

        return $this->parseJSON('get', [$url]);
    }

    /**
     * 注销机构账号（按照账号ID注销）.
     *
     * @param string $orgId 机构账号id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function deleteOrganizeAccountByOrgId($orgId)
    {
        $url = sprintf('/v1/organizations/%s', $orgId);

        return $this->parseJSON('delete', [$url]);
    }

    /**
     * 注销机构账号（按照账号ID注销）.
     *
     * @param string $thirdPartyUserId 第三方平台的机构id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function deleteOrganizeAccountByThirdId($thirdPartyUserId)
    {
        $url = sprintf('/v1/organizations/deleteByThirdId?thirdPartyUserId=%s', $thirdPartyUserId);

        return $this->parseJSON('delete', [$url]);
    }

    /**
     * 设置静默签署.
     *
     * @param string $accountId 授权人id，即个人账号id或机构账号id
     * @param null   $deadline
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function setSignAuth($accountId, $deadline = null)
    {
        $url = sprintf('/v1/signAuth/%s', $accountId);

        $params = [
            'deadline' => $deadline,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 撤销静默签署.
     *
     * @param string $accountId 授权人id，即个人账号id或机构账号id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function deleteSignAuth($accountId)
    {
        $url = sprintf('/v1/signAuth/%s', $accountId);

        return $this->parseJSON('delete', [$url]);
    }
}

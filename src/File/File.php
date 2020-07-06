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
     * 通过上传方式创建文件.
     *
     * @param string $contentMd5  先计算文件md5值，在对该md5值进行base64编码
     * @param string $contentType 目标文件的MIME类型，支持：（1）application/octet-stream（2）application/pdf
     * @param bool   $convert2Pdf 是否转换成pdf文档，默认false
     * @param string $fileName    文件名称（必须带上文件扩展名，不然会导致后续发起流程校验过不去 示例：合同.pdf ）
     * @param int    $fileSize    文件大小，单位byte
     * @param null   $accountId   所属账号id，即个人账号id或机构账号id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function getUploadFileUrl($contentMd5, $contentType, $convert2Pdf, $fileName, $fileSize, $accountId = null)
    {
        $url = '/v1/files/getUploadUrl';
        $params = [
            'contentMd5' => $contentMd5,
            'contentType' => $contentType,
            'convert2Pdf' => $convert2Pdf,
            'fileName' => $fileName,
            'fileSize' => $fileSize,
            'accountId' => $accountId,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * (模板方式)通过上传方式创建模板.
     *
     * @param string $contentMd5  先计算文件md5值，在对该md5值进行base64编码
     * @param string $contentType 目标文件的MIME类型，支持：（1）application/octet-stream（2）application/pdf
     * @param string $fileName    文件名称（必须带上文件扩展名，不然会导致后续发起流程校验过不去 示例：合同.pdf ）
     * @param bool   $convert2Pdf 是否转换成pdf文档，默认false
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function createByUploadUrl($contentMd5, $contentType, $fileName, $convert2Pdf)
    {
        $url = '/v1/docTemplates/createByUploadUrl';
        $params = [
            'contentMd5' => $contentMd5,
            'contentType' => $contentType,
            'convert2Pdf' => $convert2Pdf,
            'fileName' => $fileName,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 添加输入项组件.
     *
     * @param string $templateId 模板id
     * @param int    $type       输入项组件类型，1-文本，2-数字,3-日期，6-签约区
     * @param string $label      输入项组件显示名称
     * @param float  $width      输入项组件宽度
     * @param float  $height     输入项组件高度
     * @param int    $page       页码
     * @param float  $x          x轴坐标，左下角为原点
     * @param float  $y          y轴坐标，左下角为原点
     * @param int    $font       填充字体,默认1，1-宋体，2-新宋体，3-微软雅黑，4-黑体，5-楷体
     * @param int    $fontSize   填充字体大小,默认12
     * @param string $textColor  字体颜色，默认#000000黑色
     * @param null   $id         输入项组件id，使用时可用id填充，为空时表示添加，不为空时表示修改
     * @param null   $key        模板下输入项组件唯一标识，使用模板时也可用根据key值填充
     * @param bool   $required   是否必填，默认true
     * @param null   $limit      输入项组件type=2,type=3时填充格式校验规则;数字格式如：# 或者 #00.0# 日期格式如： yyyy-MM-dd
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function createInputOption(
        $templateId,
        $type,
        $label,
        $width,
        $height,
        $page,
        $x,
        $y,
        $font = 1,
        $fontSize = 12,
        $textColor = '#000000',
        $id = null,
        $key = null,
        $required = true,
        $limit = null
    ) {
        $url = sprintf('/v1/docTemplates/%s/components', $templateId);

        $params = [
            'structComponent' => [
                'id' => $id,
                'key' => $key,
                'type' => $type,
                'context' => [
                    'label' => $label,
                    'required' => $required,
                    'limit' => $limit,
                    'style' => [
                        'width' => $width,
                        'height' => $height,
                        'font' => $font,
                        'fontSize' => $fontSize,
                        'textColor' => $textColor,
                    ],
                    'pos' => [
                        'page' => $page,
                        'x' => $x,
                        'y' => $y,
                    ],
                ],
            ],
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * 删除输入项组件.
     *
     * @param string $templateId 模板id
     * @param string $ids        输入项组件id集合，逗号分隔
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function deleteInputOptions($templateId, $ids)
    {
        $url = sprintf('/v1/docTemplates/%s/components/%s', $templateId, $ids);

        return $this->parseJSON('delete', [$url]);
    }

    /**
     * 查询模板详情/下载模板.
     *
     * @param string $templateId 模板id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function downloadDocTemplate($templateId)
    {
        $url = sprintf('/v1/docTemplates/%s', $templateId);

        return $this->parseJSON('get', [$url]);
    }

    /**
     * (模板方式)通过模板创建文件.
     *
     * @param string $templateId       模板编号
     * @param string $name             文件名称（必须带上文件扩展名，不然会导致后续发起流程校验过不去 示例：合同.pdf ）；
     * @param string $simpleFormFields 输入项填充内容，key:value 传入
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function createByTemplate($templateId, $name, $simpleFormFields)
    {
        $url = '/v1/files/createByTemplate';
        $params = [
            'name' => $name,
            'templateId' => $templateId,
            'simpleFormFields' => $simpleFormFields,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }

    /**
     * @param string $fileId 文件id
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function downloadFile($fileId)
    {
        $url = sprintf('/v1/files/%s', $fileId);

        return $this->parseJSON('get', [$url]);
    }

    /**
     * @param array       $files        文件信息
     * @param string|null $notifyUrl    水印图片全部添加完成回调地址
     * @param string|null $thirdOrderNo 三方流水号（唯一），有回调必填
     *
     * @return Collection|null
     *
     * @throws HttpException
     */
    public function batchAddWatermark($files, $notifyUrl = null, $thirdOrderNo = null)
    {
        $url = '/v1/files/batchAddWatermark';

        $params = [
            'files' => $files,
            'notifyUrl' => $notifyUrl,
            'thirdOrderNo' => $thirdOrderNo,
        ];

        return $this->parseJSON('json', [$url, $params]);
    }
}

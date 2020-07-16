<h1 align="center"> laravel-esign </h1>

<p align="center"> E签宝-悟空API V2, 支持 laravel </p>


## Installing

```shell
$ composer require nilsir/laravel-esign -vvv
```

## Usage

generate config file
```shell
$ php artisan vendor:publish --provider="Nilsir\LaravelEsign\ServiceProvider"
```

```php
$eSign = app('esign');

$thirdPartyUserId = 'your_party_user_id'; // 用户唯一标识，可传入第三方平台的个人用户id、证件号、手机号、邮箱等，如果设置则作为账号唯一性字段，相同信息不可重复创建。
$name = 'your_name'; // 姓名
$idType = 'CRED_PSN_CH_IDCARD'; // 证件类型
$idNumber = 'your_id_number'; // 证件号
$mobile = 'your_mobile'; // 手机号, 签署流程开始时对应的签署人会收到短信通知
$email = 'your_email'; // 邮箱地址, 签署流程开始时对应的签署人会收到邮件通知

// 个人账户创建, 有唯一标志, 需要记录返回的 accountId
$accountInfo = $eSign->account->createPersonalAccount($thirdPartyUserId, $name, $idType, $idNumber, $mobile, $email);
$accountId = $accountInfo['accountId'];

// 测试合同模板ID
$templateId = 'd895b34de77041dca853aa454c042cb2';

// 测试合同模板填充变量
$simpleFormFields = [
    '1a54591dcb5f40bb86048743e7e21c18' => '测试名称',
    '9b55340f5a7a4b089dd7c03a397fa4ef' => '测试甲方',
    'c7efd37736a94e1c85ffb21fd0de88ff' => date('Y-m-d'),
];

// 根据模板创建文档
$fileInfo = $eSign->file->createByTemplateId($templateId, '租赁合同', $simpleFormFields);
$fileId = $fileInfo['fileId'];

// 创建一个签署流程
$flowInfo = $eSign->signflow->createSignFlow("租赁合同");
$flowId = $flowInfo['flowId'];

// 把文档加入签署流程中
$addDocRet = $eSign->signflow->addDocuments($flowId, $fileId);

// 在签署流程中添加一个手动签署区域, 前提是流程已经添加文档, 同时指定签署人 accountId
$handSignData = $eSign->signflow->addHandSign($flowId, $fileId, $accountId, 1, 100, 100);

// 签署流程开始, 签署人会收到通知 (前提有 mobile/email)
$startSignFlowRet = $eSign->signflow->startSignFlow($flowId);
echo $startSignFlowRet;
```

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/nilsir/laravel-esign/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/nilsir/laravel-esign/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT
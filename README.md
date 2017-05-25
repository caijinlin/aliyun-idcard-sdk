## 阿里云身份证验证接口

- 添加一个repositories

```php
{
  "type": "vcs",
  "url": "git@git.lxi.me:package/aliyun-idcard-sdk.git"
}
```

- composer require

```php
composer require "lingxi/ali-idcard-sdk"
```


- use

```php

use Lingxi\AliIdCard\Client as AliIdCardClient;
$this->aliIdCardClient = new AliIdCardClient('your appcode');

```

接口例子：

> 根据姓名和身份证号核对信息

```php
$this->aliIdCardClient->call('verify', [
    'name'   => '你的姓名',
    'cardno' => '你的身份证号',  
]);  
```

> 根据身份证正反面照片查找身份证号

```php
$this->client->call('idcard', [
    'inputs' => [
        0 => [
            'image' => [
                'dataType' => 50,
                'dataValue' => base64_encode('xxxx'), // 身份证正面图片的base64编码
            ],
            'configure' => [
                'dataType' => 50,
                'dataValue' => json_encode(['side' => 'face']), // 身份证正面,
            ],
        ],
        1 => [
            'image' => [
                'dataType' => 50,
                'dataValue' =>  base64_encode('xxxx'), // 身份证反面图片的base64编码
            ],
            'configure' => [
                'dataType' => 50,
                'dataValue' => json_encode(['side' => 'back']), // 身份证正反面,
            ],
        ],
    ]
]);
```
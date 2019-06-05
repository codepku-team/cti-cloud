<h1 align="center"> cti-cloud </h1>

<p align="center"> CtiCloud Api Service.</p>


## Installing

```shell
$ composer require codepku/cti-cloud -vvv
```

## Usage

```php
<?php
use Codepku\CtiCloud\CtiCloud;

$config = [
        'region' => 'your-region',
        'version' => 'v10',
        'validate_type' => 2, //使用的验证方式，1：部门编号；2：呼叫中心编号
        'department_id' => 'your-department-id',
        'enterprise_id' => 'you-enterprise-id',
        'department_token' => 'your-token',
        'env' => 'dev',
        'debug' => true,
        'log' => [
            'name' => 'cti-cloud',
            'file' => 'path/to/cti-cloud.log', //绝对路径
            'level' => 'debug',
            'permission' => 0777
        ],
    
        'err_code' => [
            //系统错误码
            10001 => '系统异常',
            10002 => '超出请求频度限制',
            10003 => '权限验证失败',
            10004 => '企业状态异常',
    
            //业务通用错误码
            20000 => '参数不正确，包括参数为空和格式不准确',
            20011 => '座席正忙',
            20012 => '座席不存在或不在线',
            20013 => '座席不在任何队列',
            20014 => '座席类型错误(电脑座席, 电话座席)',
            20015 => '座席未激活',
            20016 => '座席呼叫权限限制',
            20017 => '座席不在空闲状态',
            20018 => '座席不在响铃状态',
            20019 => '座席不在保持状态',
            20020 => '座席不在忙碌状态',
            20021 => '座席状态已经空闲',
            20024 => '座席没有开启外呼功能',
            20031 => '号码限制，号码在黑名单中或不在白名单中',
            20032 => '外显号码不在企业账户中',
            20051 => 'CMC呼叫限制',
            20052 => 'CMC黑名单或非白名单',
            20053 => 'CMC禁拨时间段',
        ]
       ];

    $application = new CtiCloud($config);
    
    //座席上线
    $application->agent->login('100001', '13800000000', 1);
    
    //todo more
```

## License

MIT
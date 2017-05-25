<?php

use Lingxi\AliIdCard\Client as AliIdCardClient;

class IdCardTest extends PHPUnit_Framework_TestCase 
{
    protected $client;

    public function __construct()
    {
        $this->client = new AliIdCardClient('your appcode');
    }

    public function test_verify_by_name_and_idcard()
    {
        $response = $this->client->call('verify', [
            'name'   => '你的姓名',
            'cardno' => '你的身份证号',  
        ]);  

        $this->assertEquals($response, null);
    }

    public function test_get_idcard()
    {
        $response = $this->client->call('idcard', [
            'inputs' => [
                0 => [
                    'image' => [
                        'dataType' => 50,
                        'dataValue' => base64_encode(md5(uniqid())),
                    ],
                    'configure' => [
                        'dataType' => 50,
                        'dataValue' => json_encode(['side' => 'face']), // 身份证正面,
                    ],
                ],
                1 => [
                    'image' => [
                        'dataType' => 50,
                        'dataValue' => base64_encode(md5(uniqid())),
                    ],
                    'configure' => [
                        'dataType' => 50,
                        'dataValue' => json_encode(['side' => 'back']), // 身份证正反面,
                    ],
                ],
            ]
        ]);

        $this->assertEquals($response, null);
    }
}
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
}
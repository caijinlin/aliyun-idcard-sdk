<?php

namespace Lingxi\AliIdCard;

use Lingxi\AliIdCard\Request as AliIdCardQuest;
use Lingxi\AliIdCard\ApiResponse;
use cszchen\citizenid\Parser;

class Client
{
    protected $apiUrls = [
        'verify' => [
            'method' => 'GET',
            'url' => 'http://aliyun.id98.cn/idcard', // 验证姓名和身份证号是否一致
        ],
        'idcard' => [
            'method' => 'POST',
            'url' => 'http://dm-51.data.aliyun.com/rest/160601/ocr/ocr_idcard.json', // 从身份证正反面图片信息中获取身份证号
        ],
    ];

    public function __construct($appCode)
    {
        $this->request = new AliIdCardQuest($appCode);
    }

    protected function getApi($api)
    {
        return $this->apiUrls[$api];
    }

    public function call($api, $params)
    {
        if (!isset($this->apiUrls[$api])) {
            throw new \Exception("不支持的接口类型：" . $api);
        }

        if (method_exists($this, $api)) {
            return $this->{$api}($params);
        } else {
            return $this->request->curl($this->apiUrls[$api]['url'], $params);
        }
    }

    protected function _call($api, $params)
    {
        $apiDetail = $this->getApi($api);

        return $this->request->curl($apiDetail['url'], $params, $apiDetail['method']);
    }

    /**
     * @url https://market.aliyun.com/products/57000002/cmapi012507.html?spm=5176.730005.0.0.Ajwufu#sku=yuncode650700000
     * @param $params type array
     */
    public function verify($params)
    {
        if (!$params['name'] || !$params['cardno']) {
            return ApiResponse::error('参数补全');
        }

        $parser = new Parser();
        $parser->setId($params['cardno']);

        if (!$parser->isValidate()) {
            return ApiResponse::error('身份证号码格式错误');
        }

        $result = $this->_call('verify', $params);

        if ($result['code'] == 1) {
            return ApiResponse::success($result['data']['err'], $result['data']);
        } else {
            $err = $result['isok'] == 0 ? '查询失败' : '姓名与身份证号不匹配';
            return ApiResponse::error($err, $result['data']);
        }
    }

    /**
     * @url https://market.aliyun.com/products/57124001/cmapi010401.html?spm=5176.730005.0.0.Ajwufu#sku=yuncode440100000
     * @param type array
     */
    public function idcard($params)
    {
        if (is_array($params)) {
            $params = json_encode($params);
        }

        $result = $this->_call('idcard', $params);

        return ApiResponse::success('', $result);
    }
}
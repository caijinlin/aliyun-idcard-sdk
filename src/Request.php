<?php

namespace Lingxi\AliIdCard;

class Request
{
    const METHOD_GET  = 'GET';
    const METHOD_POST = 'POST';

    protected $appcode;

    public function __construct($appcode)
    {
        $this->appcode = $appcode;
    }

    protected function _request($method, $url, $data = [])
    {
        $ch = curl_init();

        $headers = [];
        array_push($headers, "Authorization:APPCODE " . $this->appcode);
        array_push($headers, "Content-Type" . ":" . "application/json; charset=UTF-8");

        if ($method == self::METHOD_GET) {
            $url = $url . "?" . http_build_query($data);
        } 

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false); // 不返回头信息

        if (0 === strpos($url, "https://")) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        if ($method === 'POST') {

            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $result =  curl_exec($ch);

        curl_close($ch);

        return json_decode($result, true);

    }

    public function curl($url, $querys, $method)
    {
        switch ($method) {
            case self::METHOD_GET:
                return $this->get($url, $querys);
                break;
            case self::METHOD_POST:
                return $this->post($url, $querys);
            default:
                throw new \Exception('不支持' . $method . '请求类型');
                break;
        }
    }

    protected function get($url, $data)
    {
        $result =  $this->_request(self::METHOD_GET, $url, $data);

        return $result;
    }

    protected function post($url, $data)
    {
        return $this->_request(self::METHOD_POST, $url, $data);
    }
}

<?php

namespace Lingxi\AliIdCard;

class ApiResponse
{
    public static function success($msg = true, $data = [])
    {
        return [
            'success' => true,
            'msg'  => $msg,
            'data' => $data,
        ];
    }

    public static function error($msg, $data = [])
    {
        return [
            'success' => false,
            'msg'  => $msg,
            'data' => $data,
        ];
    }
}

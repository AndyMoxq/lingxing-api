<?php
namespace ThankSong\LingXing\Services;

use ThankSong\LingXing\Exception\InvalidResponseException;
use ThankSong\LingXing\Exception\RequestException;

class IpService {
    public static function getIp(){
        $url = 'https://toolbox.lingxing.com/api/getIp';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res, true);
        if($res['success'] ?? false){
            return $res['data'];
        }else{
            throw new InvalidResponseException('获取IP地址异常');
        }
    }
}
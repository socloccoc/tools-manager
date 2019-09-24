<?php

namespace App\Helpers;
class KeyHelper
{
    const SERVER_KEY_URL = 'http://localhost:8000/api/v1/';

    public static function getPointByKey($key)
    {
        $url = self::SERVER_KEY_URL . 'getPointByKey/' . $key;
        $point = self::curlGet($url, false);
        return $point;
    }

    public static function addPointforKey($key, $point)
    {
        $data = ['key' => $key, 'point' => $point];
        $url = self::SERVER_KEY_URL . 'addPointForKey';
        $result = self::curlPost($url, $data);
        return $result;
    }

    public static function apps(){
        $url = self::SERVER_KEY_URL . 'app';
        $result = self::curlGet($url, false);
        return $result;
    }

    public static function validateKey($key, $appId){
        $data = ['key' => $key, 'app_id' => $appId];
        $url = self::SERVER_KEY_URL . 'validateKey';
        $result = self::curlPost($url, $data);
        return $result;
    }

    public static function curlGet($url, $tls = true)
    {
        try {
            $ch = curl_init();

            if ($ch === false) {
                throw new \Exception('failed to initialize');
            }

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            if ($tls) {
                curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'DES-CBC3-SHA');
            }

            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/72.4.208 Chrome/66.4.3359.208 Safari/537.36');
            curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com');
            curl_setopt($ch, CURLOPT_ENCODING, '');

            $headers = array();
            $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/72.4.208 Chrome/66.4.3359.208 Safari/537.36';
            $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8';
            $headers[] = 'accept-encoding: gzip, deflate, br';
            $headers[] = 'accept-language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            curl_setopt($ch, CURLOPT_URL, $url);

            $content = curl_exec($ch);

            if ($content === false) {
                throw new \Exception(curl_error($ch), curl_errno($ch));
            }

            curl_close($ch);

            return json_decode($content, true);
        } catch (\Exception $e) {
            trigger_error(sprintf('Curl failed with error #%d: %s', $e->getCode(), $e->getMessage())
                , E_USER_ERROR);
        }
    }

    public static function curlPost($url, $data)
    {

        $payload = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) coc_coc_browser/72.4.208 Chrome/66.4.3359.208 Safari/537.36');


        // Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "accept: */*",
            'Content-Type: application/json',
        ));

        // Submit the POST request
        $result = curl_exec($ch);

        // Close cURL session handle
        curl_close($ch);

        return json_decode($result, true);


    }
}

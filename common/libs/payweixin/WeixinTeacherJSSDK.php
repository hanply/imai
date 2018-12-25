<?php

namespace common\components;

use Yii;

/**
 * 微信JS-SDK
 */

class WeixinTeacherJSSDK {
    
    private $appId;
    private $appSecret;
    
    private $accessToken = '{"access_token":"","expire_time":0}';
    private $jsapiTicket = '{"jsapi_ticket":"","expire_time":0}';
    
    private static $appInstance;
    
    public static function getInstance()
    {
        if (!isset(self::$appInstance)) {
            self::$appInstance = new self();
            self::$appInstance->appId = Yii::$app->params['weixin_teacher']['app_id'];
            self::$appInstance->appSecret = Yii::$app->params['weixin_teacher']['app_secret'];
        }
        return self::$appInstance;
    }
    
    public function getSignPackage()
    {
        $jsapiTicket = $this->getJsApiTicket();
        
        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        $timestamp = time();
        $nonceStr = $this->createNonceStr();
        
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        
        $signature = sha1($string);
        
        $signPackage = array(
          "appId"     => $this->appId,
          "nonceStr"  => $nonceStr,
          "timestamp" => $timestamp,
          "url"       => $url,
          "signature" => $signature,
          "rawString" => $string
        );
        return $signPackage;
    }
    
    private function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    
    public function getJsApiTicket()
    {
        $cache_key = 'weixin_jsapi_ticket_'. $this->appId;
        $cache_val = Yii::$app->cache->get($cache_key);
        if (empty($cache_val)) {
            $cache_val = $this->jsapiTicket;
        }
        $data = json_decode($cache_val);
        if ($data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = isset($res->ticket) ? $res->ticket : '';
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $cache_set = Yii::$app->cache->set($cache_key, json_encode($data), 7000);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }
        
        return $ticket;
    }
    
    public function getAccessToken()
    {
        $cache_key = 'weixin_access_token_'. $this->appId;
        $cache_val = Yii::$app->cache->get($cache_key);
        if (empty($cache_val)) {
            $cache_val = $this->accessToken;
        }
        $data = json_decode($cache_val);
        if ($data->expire_time < time()) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url));
            $access_token = isset($res->access_token) ? $res->access_token : '';
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $cache_set = Yii::$app->cache->set($cache_key, json_encode($data), 7000);
            }
        } else {
            $access_token = $data->access_token;
        }
        return $access_token;
    }
    
    private function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        
        $res = curl_exec($curl);
        curl_close($curl);
        
        return $res;
    }





}


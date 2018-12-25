<?php

namespace common\components;

use Yii;

/**
 * 微信支付
 */
class WeixinPay
{
    //交易类型
    const TRADE_TYPE_JSAPI = 'JSAPI';
    const TRADE_TYPE_NATIVE = 'NATIVE';

    //附加类型
    const ATTACH_TYPE_ORDER = 'ORDER';
    const ATTACH_TYPE_TOPUP = 'TOPUP';

    //获取公众号订单
    public function getOrderByJsApi($open_id, $params)
    {
        return $this->getUnifiedOrder(self::TRADE_TYPE_JSAPI, $open_id, $params);
    }

    //获取扫码订单
    public function getOrderByNative($open_id, $params)
    {
        return $this->getUnifiedOrder(self::TRADE_TYPE_NATIVE, $open_id, $params);
    }

    //获取统一下单
    public function getUnifiedOrder($trade_type, $open_id, $order_params)
    {
        $weixin = Yii::$app->params['weixin'];
        $params = array(
            'appid' => $weixin['app_id'],                              //公众账号ID
            'mch_id' => $weixin['pay_mchid'],                          //商户号
            'device_info' => 'WEB',                                    //设备号
            'nonce_str' => md5(time()),                                //随机字符串
            'body' => $order_params['body'],                           //商品描述
            'detail' => $order_params['detail'],                       //商品详情
            'attach' => $order_params['attach'],                       //附加数据
            'out_trade_no' => $order_params['out_trade_no'],           //商户订单号
            'fee_type' => 'CNY',                                       //标价币种
            'total_fee' => $order_params['total_fee'],                 //标价金额，单位分
            'spbill_create_ip' => Yii::$app->request->userIP,          //终端IP
            'notify_url' => $order_params['notify_url'],               //通知地址
            'trade_type' => $trade_type,                               //交易类型
            'product_id' => $order_params['product_id'],               //商品ID
            'openid' => $open_id,                                      //用户标识
        );
        
        //数据签名
        $params['sign'] = $this->getDataSign($params);

        //请求接口
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $xml = $this->getRequestXml($params);
        $result = Yii::$app->common->curl($url, $xml);
        $data = $this->getParseXml($result);

        error_log(date('Y-m-d H:i:s') . ' url: '. $url . ', params: ' . $xml . ', data: ' . $result . PHP_EOL, 3, Yii::getAlias("@runtime") . '/logs/weixin_pay.log');

        return $data;
    }

    //获取唤起参数
    public function getArouseParams($prepay_id)
    {
        $params = array(
            'appId' => Yii::$app->params['weixin']['app_id'],
            'timeStamp' => strval(time()),
            'nonceStr' => md5(time()),
            'package' => 'prepay_id=' . $prepay_id,
            'signType' => 'MD5',
        );

        //数据签名
        $params['paySign'] = $this->getDataSign($params);
        $result = json_encode($params);

        return $result;
    }

    //获取二维码数据
    public function getQrCodeData($product_id)
    {
        $weixin = Yii::$app->params['weixin'];
        $params = array(
            'appid' => $weixin['app_id'],
            'mch_id' => $weixin['pay_mchid'],
            'time_stamp' => time(),
            'nonce_str' => md5(time()),
            'product_id' => $product_id,
        );

        //数据签名
        $params['sign'] = $this->getDataSign($params);

        //生成内容
        $url = 'weixin://wxpay/bizpayurl';
        $data = $url . '?' . http_build_query($params);

        return $data;
    }

    //获取订单退款
    public function getOrderRefund($refund_sn, $refund_price, $notify_url, $order_params)
    {
        $weixin = Yii::$app->params['weixin'];
        $params = array(
            'appid' => $weixin['app_id'],                              //公众账号ID
            'mch_id' => $weixin['pay_mchid'],                          //商户号
            'nonce_str' => md5(time()),                                //随机字符串
            'transaction_id' => $order_params['transaction_id'],       //微信订单号  
            'out_trade_no' => $order_params['out_trade_no'],           //商户订单号
            'out_refund_no' => $refund_sn,                             //商户退款单号
            'total_fee' => $order_params['total_fee'],                 //订单金额
            'refund_fee' => $refund_price,                             //退款金额
            'refund_fee_type' => 'CNY',                                //退款货币种类
            // 'notify_url' => $notify_url,                               //退款结果通知url
        );
        
        //数据签名
        $params['sign'] = $this->getDataSign($params);

        //证书
        $cert = array(
            'ssl_cert' => Yii::getAlias("@common") . '/components/cert/weixin_pay_cert.pem',
            'ssl_key' => Yii::getAlias("@common") . '/components/cert/weixin_pay_key.pem',
        );

        //请求接口
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        $xml = $this->getRequestXml($params);
        $result = Yii::$app->common->curl($url, $xml, 'POST', $cert);

        error_log(date('Y-m-d H:i:s') . ' url: '. $url . ', params: ' . $xml . ', data: ' . $result . PHP_EOL, 3, Yii::getAlias("@runtime") . '/logs/weixin_pay.log');

        return $result;
    }

    //获取请求XML
    public function getRequestXml($params)
    {
        $xml = '<xml>';
        foreach ($params as $key => $val) {
            if (is_numeric($val)) {
                $xml .= '<'. $key .'>'. $val.'</'.$key.'>';
            } else {
                $xml .= '<'. $key .'><![CDATA['. $val .']]></'. $key .'>';
            }
        }
        $xml .= '</xml>';
        
        return $xml; 
    }

    //获取解析XML
    public function getParseXml($xml)
    {
        //屏蔽XML错误
        libxml_use_internal_errors(true);
        
        //解析XMl数据
        $xml = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (false === $xml) {
            return array();
        }
        $data = json_decode(json_encode($xml), true);

        return $data;
    }

    //获取数据签名
    public function getDataSign($params)
    {
        //参数排序
        ksort($params);

        //遍历参数
        $arg = '';
        foreach ($params as $key => $val) {
            if (empty($val)) {
                continue;
            }
            $arg .= $key .'='. $val . '&';
        }
        $arg = trim($arg, '&');

        //删除反斜杠
        if (get_magic_quotes_gpc()) {
            $arg = stripslashes($arg);
        }

        //生成签名
        $arg .= '&key=' . Yii::$app->params['weixin']['pay_key'];
        $sign = strtoupper(md5($arg));
        
        return $sign;
    }
}

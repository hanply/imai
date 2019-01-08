<?php
namespace common\libs;

class Yformat
{
    /**
     * 格式化手机号-前后各留两位，中间****展示
     * @param  string $mobile 手机号
     * @return string         格式后的手机号
     */ 
    public static function mobile($mobile) {
        if (strlen($mobile) != 11) {
            return '手机号码格式不正确';
        }
        $newMobile = substr($mobile, 0,3).'****'.substr($mobile, 7, 4);
        return $newMobile;
    } 

    /**
     * 身份证号码格式化 前后各4 中间*
     * @param  string $idcard 身份证号码
     * @return string         
     */
    public static function idcard($idcard) {
        $length = strlen($idcard);
        return substr($idcard, 0, 4).'************'.substr($idcard, $length - 4, 4);
    }

    /**
     * 银行卡格式化 前6位 后4位 中间*
     * @param  string $bankCardNo 银行卡号码
     * @return string         
     */
    public static function bank($bankCardNo) {
        $length = strlen($bankCardNo);
        if ($length < 10) {
            return $bankCardNo;
        }else {
            $prefix = substr($bankCardNo, 0, 6);
            $suffix =  substr($bankCardNo, $length - 4, 4);
            $middle = '';
            for($i = 0; $i < $length - 10; $i ++) {
                $middle.= '*';
            }
            return $prefix.$middle.$suffix;
        }
    }

    /**
     * 格式化字节大小
     * @param  number $size      字节数
     * @param  string $delimiter 数字和单位分隔符
     * @return string            格式化后的带单位的大小
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public static function bytes($size, $delimiter = '') {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
        return round($size, 2) . $delimiter . $units[$i];
    }
}
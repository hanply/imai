<?php
namespace common\libs;
/**********************************************校验*************************************************/
class Ycheck
{
    /**
     * 校验手机号
     * @param  string $mobilehone [description]
     * @return [type]             [description]
     */
    public static function mobile($mobile = '')
    {
        if(preg_match("/1[3456789]{1}\d{9}$/", $mobile)){
            return true;
        }
        return false;
    }

    public static function idcard($idcard = '') {
        if (preg_match("/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/",$idcard)) {
            return TRUE;
        }
        return FALSE;
    }

    public static function email($email = '') {
        if (preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",$email)) {
            return TRUE;
        }
        return FALSE;
    }
}
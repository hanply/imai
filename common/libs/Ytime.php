<?php
namespace common\libs;
/**
 * 时间处理相关类
 */
class Ytime
{

    /**
     * 时间戳格式化
     * @param int $time
     * @return string 完整的时间显示
     * @author huajie <banhuajie@163.com>
     */
    public static function timestampToDate($timestamp = 0, $format='Y-m-d H:i:s')
    {   
        $timestamp = intval($timestamp);
        if (empty($timestamp)) {
            return '';
        }
        return date($format, $timestamp);
    }

    /*
     *按今天,昨天,本周,本月,上周,上月的起始时间戳
     *$day 代表查询条件
     *$result 返回结果    
     */
    public static function find_time($day)
    {
        //获取当天时间戳
        if($day == 1){
            $data['today']  = strtotime(date('Ymd').'000001');
            $data['result'] = array('egt',$data['today']);
            return $data;
        //获取昨天起始时间戳
        }else if($day == 2){
            $data['start']  =  mktime(0,0,0,date('m'),date('d')-1,date('Y')); 
            $data['end']    =  mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
            $data['result'] = array('between',array($data['start'],$data['end']));
            return $data;
        //获取本周起始时间戳
        }else if($day == 3){
            $w      = date( "w",time());
            $data['start']  = mktime(0,0,0,date( "m"), date( "d") - $w,date( "Y"));
            $data['end']    = mktime(23,59,59,date( "m"), date( "d") - $w + 6,date( "Y"));
            $data['result'] = array('between',array($data['start'],$data['end']));
            return $data;
        //获取本月起始时间戳
        }else if($day == 4){
            $data['start']  =  mktime(0, 0, 0, date('m'), 1, date('Y'));
            $data['end']    =  mktime(23, 59, 59, date('m'), date('t'), date('Y'));  
            $data['result'] =  array('between',array($data['start'],$data['end']));
            return $data;
        //获取上周起始时间戳
        }else if($day == 5){
            $data['start']  = mktime(0,0,0,date('m'),date('d')-date('w')-7,date('Y'));
            $data['end']    = mktime(23,59,59,date('m'),date('d')-date('w')+6-7,date('Y'));
            $data['result'] =  array('between',array($data['start'],$data['end']));
            return $data;
        //获取上月起始时间戳
        }else if($day == 6){
            $data['start']  = strtotime(date('Y-m-01 00:00:00',strtotime('-1 month')));  
            $data['end']    = strtotime(date("Y-m-d 23:59:59", strtotime(-date('d').'day')));
            $data['result'] =  array('between',array($data['start'],$data['end']));
            return $data;
        }
    }

    /**
     * 时间细分  2017-08-08
     * @param $createtime 时间戳
     */
    public static function time_refine($createtime)
    {
        $time = time() - $createtime;
        $days = intval($time / 86400);
        //计算小时数
        $remain = $time % 86400;
        $hours = intval($remain / 3600);
        //计算分钟数
        $remain = $remain % 3600;
        $mins = intval($remain / 60);
        //计算秒数
        $secs = $remain % 60;
        if ($days != 0) {
            $time = $days . '天前';
        } elseif ($hours != 0) {
            $time = $hours . '小时前';
        } elseif ($mins != 0) {
            $time = $mins . '分钟前';
        } else {
            $time = $secs . '秒前';
        }
        return $time;
    }

    /** 
     * 转换周几  2016-07-22
     * @param $week 周几数字格式
     */
    public static function toweek($week)
    {
        switch ($week){
            case 0:
                return '日';
            case 1:
                return '一';
            case 2:
                return '二';
            case 3:
                return '三';
            case 4:
                return '四';
            case 5:
                return '五';
            case 6:
                return '六';
            default:
                return false;
        }
    } 
}
<?php
/**
 * 16:49 2018/7/19
 * @class  短信接口 --漫道
 * @author duoduo
 */
namespace common\components;

use Yii;
class SmsAPI {
    const signName = '【YOYOGA】';
    private $sn = 'SDK-BBX-010-25119';
    private $password = 'ef(8a-62';
    private $pwd;
    
    public function __construct() {
        $this->pwd = strtoupper(md5($this->sn.$this->password));
    }
    /* 发送短信
     * @pargam string mobiles  手机号
     * @pargam string message  短信内容
     * @return null
     */
    public function send($mobiles = '', $message = '',$type='',$time='') {
        if (!\Yii::$app->params['sms']) {
            return false;
        }
        if (empty($mobiles) || empty($message)) {
            return false;
        }
        $message = $message.self::signName;
        $url = "http://sdk.entinfo.cn:8061/mdsmssend.ashx?sn={$this->sn}&pwd={$this->pwd}&mobile={$mobiles}&content=".rawurlencode($message)."&ext=&stime=".rawurlencode($time)."&rrid=&msgfmt=";
        
        //$binarydata = pack("A", $post_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
       // curl_setopt($ch, CURLOPT_POST, 0);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);
        curl_close($ch);
        $nowdate = date('Y-m-d,H:i:s');
        $code_text = '发送成功';
        $time = $time?$time:date('Y-m-d H:i:s');

        if($data == false) {
            $data = -9999;
        }
        if($data < 0 ){
           $code_text = $this->getCodeText((string)$data);
           /*  $mobiles_array = @explode(',',$mobiles);
            if(is_array($mobiles_array)){
                foreach($mobiles_array as $v){
                    $insertData[] = array(
                        'mobile'=> $v,
                        'content'=> $message,
                        'code'=> (string)$data,
                        'code_text'=> $code_text,
                        'type'=> $type,
                        'send_time'=> $time,
                        'status'=> -1,
                        'create_time'=> $nowdate,
                    );
                }
                if(!$this->saveMdSmsLogs($insertData)){
                    $multi_mobiles = implode(',',$mobiles_array);
                    //错误日志写文件
                    $content = date('Y-m-d H:i:s') . " - {$mobiles} - {$message} - {$data} -  {$this->getCodeText((string)$data)}";
                    $this->write_log($content, "./application/cache/mdsms_send_error.log");    
                }
            }else{
                $insertData = array(
                    'mobile'=> $mobiles,
                    'content'=> $message,
                    'code'=> (string)$data,
                    'code_text'=> $code_text,
                    'type'=> $type,
                    'send_time'=> $time,
                    'status'=> -1,
                    'create_time'=> $nowdate,
                );
                if(!$this->saveMdSmsLog($insertData)){
                    $multi_mobiles = implode(',',$mobiles_array);
                    //错误日志写文件
                    $content = date('Y-m-d H:i:s') . " - {$multi_mobiles} - {$data} -  {$this->getCodeText((string)$data)}";
                    $this->write_log($content, "./application/cache/mdsms_send_error.log");    
                }
            }*/
            return array('status'=>0,'code_text'=>$code_text);
        }else{
           /* $mobiles_array = @explode(',',$mobiles);
            if(is_array($mobiles_array)){
                foreach($mobiles_array as $v){
                    $insertData[] = array(
                        'mobile'=> $v,
                        'content'=> $message,
                        'code'=> (string)$data,
                        'code_text'=> $code_text,
                        'type'=> $type,
                        'send_time'=> $time,
                        'status'=> 1,
                        'create_time'=> $nowdate,
                    );
                }
                if(!$this->saveMdSmsLogs($insertData)){
                    $multi_mobiles = implode(',',$mobiles_array);
                    //错误日志写文件
                    $content = date('Y-m-d H:i:s') . " - {$multi_mobiles} - {$data} -  {$this->getCodeText((string)$data)}";
                    $this->write_log($content, "./application/cache/mdsms_send_error.log");    
                }
            }else{
                $insertData = array(
                    'mobile'=> $mobiles,
                    'content'=> $message,
                    'code'=> (string)$data,
                    'code_text'=> $code_text,
                    'type'=> $type,
                    'send_time'=> $time,
                    'status'=> 1,
                    'create_time'=> $nowdate,
                );
                if(!$this->saveMdSmsLog($insertData)){
                    //错误日志写文件
                    $content = date('Y-m-d H:i:s') . " - {$mobiles} - {$message} - {$data} -  {$this->getCodeText((string)$data)}";
                    $this->write_log($content, "./application/cache/mdsms_send_error.log");    
                }
            }*/
            return array('status'=>1,'code_text'=>$code_text);
        }
    }
    
    /* 批量短信并发，发送短信
     * @pargam array mobilesAndMess  手机号  array('0'=>array('mobile'=>1854***12,'message'=>'***'),'1'=>array('mobile'=>1854***12,'message'=>'***'),..)
     * @return bool
     */
    public function sendMulti($mobilesAndMess = array()) {
        if(empty($mobilesAndMess)){
            return false;
        }
        foreach($mobilesAndMess as $v){
            $message = $v['message'].self::signName;
            $time = $v['send_time']?$v['send_time']:'';
            $url[] = "http://sdk.entinfo.cn:8061/mdsmssend.ashx?sn={$this->sn}&pwd={$this->pwd}&mobile={$v['mobile']}&content=".rawurlencode($message)."&ext=&stime=".rawurlencode($time)."&rrid=&msgfmt=";
            unset($message);
            unset($time);
        }
        // 创建批处理cURL句柄
        $mh = curl_multi_init();
        $ch = array();
        for($i = 0; $i < count($url); $i++)
        {
            $ch[$i] = curl_init();
            curl_setopt($ch[$i], CURLOPT_URL, $url[$i]);
            curl_setopt($ch[$i], CURLOPT_HEADER, 0);
            curl_setopt($ch[$i], CURLOPT_TIMEOUT, 20);
            curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
            curl_multi_add_handle($mh, $ch[$i]);
        } 
        $running=null;
        // 执行批处理句柄
        do {
            curl_multi_exec($mh,$running);
            $info = curl_multi_info_read($mh);
            if($info['handle']){
                $res[] = curl_multi_getcontent($info['handle']);
                curl_multi_remove_handle($mh, $info['handle']);
            }
        } while($running > 0);
        for($i = 0; $i < count($url); $i++)
        {
            curl_multi_remove_handle($mh, $ch[$i]);
        } 
        curl_multi_close($mh);
        $nowdate = date('Y-m-d,H:i:s');
       /* $code_text = '';
        foreach($res as $k => $data){
            if($data < 0 ){
                $code_text = $this->getCodeText((string)$data);
                $multi_mobiles[] = $mobilesAndMess[$k]['mobile'];
                $insertData[] = array(
                    'mobile'=> $mobilesAndMess[$k]['mobile'],
                    'content'=> $mobilesAndMess[$k]['message'],
                    'code'=> (string)$data,
                    'code_text'=> $code_text,
                    'type'=> $mobilesAndMess[$k]['type'],
                    'send_time'=> ($mobilesAndMess[$k]['send_time']?$mobilesAndMess[$k]['send_time']:date('Y-m-d H:i:s')),
                    'status'=> -1,
                    'create_time'=> $nowdate,
                );
            }else{
                $multi_mobiles[] = $mobilesAndMess[$k]['mobile'];
                $insertData[] = array(
                    'mobile'=> $mobilesAndMess[$k]['mobile'],
                    'content'=> $mobilesAndMess[$k]['message'],
                    'code'=> (string)$data,
                    'code_text'=> $code_text,
                    'type'=> $mobilesAndMess[$k]['type'],
                    'send_time'=> ($mobilesAndMess[$k]['send_time']?$mobilesAndMess[$k]['send_time']:date('Y-m-d H:i:s')),
                    'status'=> 1,
                    'create_time'=> $nowdate,
                );
            }
        }
        if(!$this->saveMdSmsLogs($insertData)){
            $multi_mobiles = implode(',',$multi_mobiles);
            //错误日志写文件
            $content = date('Y-m-d H:i:s') . " - {$multi_mobiles} - {$data} -  {$this->getCodeText((string)$data)}";
            $this->write_log($content, "./application/cache/mdsms_send_error.log");    
        }*/
    }
    private function saveMdSmsLog($data){
        $CI =& get_instance();
        $CI->load->database('default', 'db');
        $CI->db->insert('md_sms_log', $data);
        return $CI->db->insert_id();
    }
    private function saveMdSmsLogs($data){
        $CI =& get_instance();
        $CI->load->database('default', 'db');
        return $CI->db->insert_batch('md_sms_log', $data);
    }
    /* 发送失败写入log日志
     * @pargam string content  内容
     * @pargam string filename 写入目录文件
     * @return null
     */
    private function write_log($content, $filename) {
        if (@$fp = @fopen($filename, 'a')) {
            @flock($fp, LOCK_EX);
            @fwrite($fp, $content . "\n");
            @fclose($fp);
        }
    }
    /* code值回调错误短信文案
     * @pargam string $code  内容
     * @return null
     */
    private function getCodeText($code){
        $codeArray = array(
            -2 => '帐号/密码不正确',
            -4 => '余额不足支持本次发送',
            -5 => '数据格式错误',
            -6 => '参数有误',
            -7 => '权限受限',
            -8 => '流量控制错误',
            -9 => '扩展码权限错误',
            -10 => '内容长度长',
            -11 => '内部数据库错误',
            -12 => '序列号状态错误',
            -14 => '服务器写文件失败',
            -17 => '没有权限',
            -21 => 'Ip鉴权失败',
            -22 => 'Ip鉴权失败',
            -23 => '缓存无此序列号信息',
            -601 => '序列号为空，参数错误',
            -602 => '序列号格式错误，参数错误',
            -603 => '密码为空，参数错误',
            -604 => '手机号码为空，参数错误',
            -605 => '内容为空，参数错误',
            -606 => 'ext长度大于9，参数错误',
            -607 => '参数错误 扩展码非数字',
            -608 => '参数错误 定时时间非日期格式',
            -609 => 'rrid长度大于18,参数错误',
            -610 => '参数错误 rrid非数字',
            -611 => '参数错误 内容编码不符合规范',
            -623 => '手机个数与内容个数不匹配',
            -624 => '扩展个数与手机个数数',
            -625 => '定时时间个数与手机个数不匹配',
            -626 => 'Rrid个数与手机号个数不一致',
            -9999 => 'DNS解析失败',
        );
        return isset($codeArray[$code])?$codeArray[$code]:'异常信息，获取不到codetext';
    }
}
?>

<?php
namespace common\libs;
class Helper
{
    // 打印
    public static function v($data, $json_decode = false)
    {
        if (empty($data)) {
            return '';
        }
        if ($json_decode) {
            $data = json_decode($data, true);
        }
        if (is_array($data) || is_object($data)) {
            echo '<pre>';
            print_r($data);
        }else {
            echo $data;
        }
        exit;
    }

    // 返回json格式数据
    public static function returnJson($data)
    {
        echo json_encode($data);
        exit;
    }



/**********************************************时间*************************************************/

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






/**********************************************字符串*************************************************/

    /**
     * 生成验证码 2016-04-07
     */
    public static function createVerifycode($length = 4)
    {
        $number = "";
        for ($i = 0;$i < $length;$i++){
            $number .= rand(0,9);
        }
        return $number;
    }

    /**
     * 生成随机订单编号  2017-05-15
     * @param $length 字符串长度
     */
    public static function createCode($length = 18, $salt = '')
    {
        $number = date('ymdhis');
        for ($i=0; $i<6; $i++) {
            $number .= rand(0, 9);
        }
        if($res){
            createnumber($table);
        }else{
            return $number;
        }
    }

    /**
     * 随机字符串生成   2017-05-15
     * @param $length 字符串长度
     */
    public static function createnoncestr($length = 16) 
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for($i = 0; $i < $length; $i++){
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
     * @param string $len 长度
     * @param string $type 字串类型
     * 0 字母 1 数字 其它 混合
     * @param string $addChars 额外字符
     * @return string
     */
    public static function rand_string($len=6,$type='',$addChars='') {
        $str ='';
        switch($type) {
            case 0:
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
                break;
            case 1:
                $chars= str_repeat('0123456789',3);
                break;
            case 2:
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
                break;
            case 3:
                $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
                break;
            case 4:
                $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借".$addChars;
                break;
            default :
                // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
                $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
                break;
        }
        if($len>10 ) {//位数过长重复字符串一定次数
            $chars= $type==1? str_repeat($chars,$len) : str_repeat($chars,5);
        }
        if($type!=4) {
            $chars   =   str_shuffle($chars);
            $str     =   substr($chars,0,$len);
        }else{
            // 中文随机字
            for($i=0;$i<$len;$i++){
                $str.= msubstr($chars, floor(mt_rand(0,mb_strlen($chars,'utf-8')-1)),1);
            }
        }
        return $str;
    }

    /**
     * 数据XML编码  不含CDATA
     * @param  object $xml  XML对象    mixed  $data 数据 string $item 数字索引时的节点名称
     */
    public static function dataToXml($xml, $data, $item = 'item')
    {
        foreach ($data as $key => $value) {
            /* 指定默认的数字key */
            is_numeric($key) && $key = $item;

            /* 添加子元素 */
            if(is_array($value) || is_object($value)){
                $child = $xml -> addChild($key);
                static::dataToXml($child, $value, $item);
            }else{
                $child = $xml->addChild($key, $value);
            }
        }
    }

    /**
     * xml格式转数组
     */
    public static function xmlToArray($xml)
    {
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /*将数组的值从字符串转化成整型*/
    public static function array_intval($arr)
    {
        foreach ($arr as $key => $value) {
            $res[] = intval($value);
        }
        return $res;
    }

    /**
     * 替换四个字节的字符 '\xF0\x9F\x98\x84\xF0\x9F）的解决方案
     * @param content
     * @return
     */
    public static function removeEmoji($text) 
    {
        $clean_text = "";
        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $text);
        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);
        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);
        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);
        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
        return $clean_text;
    }

    /**
     * 根据经纬度计算距离
     * @param $lat经度 $lng维度  
     */
    public static function getDistanceByLatLng($lat1, $lng1, $lat2, $lng2)
    {
        $EARTH_RADIUS = 6378.137;
        $radLat1 = $lat1 * 3.1415926535898 / 180.0;
        $radLat2 = $lat2 * 3.1415926535898 / 180.0;
        $a = $radLat1 - $radLat2;
        $b = ($lng1 - $lng2) * 3.1415926535898 / 180.0;
        $s = 2 * asin(sqrt(pow(sin($a/2),2) +
                cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
        $s = $s *$EARTH_RADIUS;
        $s = round($s,3);//千米为单位，3位小数
        return $s;
    }









/**********************************************校验*************************************************/
    /**
     * 校验手机号
     * @param  string $mobilehone [description]
     * @return [type]             [description]
     */
    public static function checkMobile($mobile = '')
    {
        if(preg_match("/1[3456789]{1}\d{9}$/", $mobile)){
            return true;
        }
        return false;
    }

    public static function checkIdcard($idcard = '') {
        if (preg_match("/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/",$idcard)) {
            return TRUE;
        }
        return FALSE;
    }

    public static function checkEmail($email = '') {
        if (preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",$email)) {
            return TRUE;
        }
        return FALSE;
    }






/**********************************************图片*************************************************/

    /**
     * php完美实现下载远程图片保存到本地
     * @param: 文件url,保存文件目录,保存文件名称，使用的下载方式   当保存文件名称为空时则使用远程文件原来的名称
     */
    public static function getimage($url,$save_dir='',$filename='',$type=0)
    {
        if(trim($url)==''){
            return array('file_name'=>'','save_path'=>'','error'=>1);
        }
        if(trim($save_dir)==''){
            $save_dir='./';
        }
        if(trim($filename)==''){//保存文件名
            $ext=strrchr($url,'.');
            if($ext!='.gif'&&$ext!='.jpg'){
                return array('file_name'=>'','save_path'=>'','error'=>3);
            }
            $filename=time().$ext;
        }
        if(0!==strrpos($save_dir,'/')){
            $save_dir.='/';
        }
        //创建保存目录
        if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
            return array('file_name'=>'','save_path'=>'','error'=>5);
        }

        //获取远程文件所采用的方法
        if($type){
            $ch=curl_init();
            $timeout=5;
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
            $img=curl_exec($ch);
            curl_close($ch);
        }else{
            ob_start();
            readfile($url);
            $img=ob_get_contents();
            ob_end_clean();
        }
        //$size=strlen($img);
        //文件大小

        $fp2=@fopen($save_dir.$filename,'a');
        fwrite($fp2,$img);
        fclose($fp2);
        unset($img,$url);
        return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);
    }

    /**
    * 图片剪切成圆形
    * @param  [type] $url  [description]
    * @param  [type] $path [description]
    * @return [type]       [url]
    */
    public static function test($url,$path)
    {       
        list($w, $h) = getimagesize($url); 
        //$img = getimagesize($url); 
        //$img = token_get_all(file_get_contents($url));
        //var_dump($img,'------------');
        //$w = 272.5;  $h=272.5; // original size  
        $original_path= $url;
        $dest_path = $path;  
        $src = imagecreatefromstring(file_get_contents($original_path)); 

        $newpic = imagecreatetruecolor($w,$h);  
        imagealphablending($newpic,false);  
        $transparent = imagecolorallocatealpha($newpic, 0, 0, 0, 127);  
        $r=$w/2;  
        for($x=0;$x<$w;$x++)  
            for($y=0;$y<$h;$y++){  
                $c = imagecolorat($src,$x,$y);  
                $_x = $x - $w/2;  
                $_y = $y - $h/2;  
                if((($_x*$_x) + ($_y*$_y)) < ($r*$r)){  
                    imagesetpixel($newpic,$x,$y,$c);  
                }else{  
                    imagesetpixel($newpic,$x,$y,$transparent);  
                }  
            }  
        imagesavealpha($newpic, true);  
        imagepng($newpic, $dest_path);  
        imagedestroy($newpic);  
        imagedestroy($src);  
       // unlink($url);  
        return $dest_path;  
    }

    public static function dealPic($imageUrl,$type='') {
        $imageArr = array('s' => '', 'b' => '', 'l' => '');
        if (empty($imageUrl)) {
            return '';
        }
        $dirname = dirname($imageUrl);
        $imageName = strrchr($imageUrl, '/');
        $s_imageurl = $dirname . str_replace('/', '/s_', $imageName);
        $b_imageurl = $dirname . str_replace('/', '/b_', $imageName);
        $l_imageurl = $dirname . str_replace('/', '/l_', $imageName);
        $imageArr['s'] = $s_imageurl;
        $imageArr['b'] = $b_imageurl;
        $imageArr['l'] = $l_imageurl;
        if($type){
            return $imageArr[$type];
        }else{
            return $imageArr;
        }
    } 







/**********************************************url*************************************************/

    // 获取当前全部url
    public static function get_url()
    {
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
        return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
    }

    /**
     * 获取当前的网址加目录信息
     */
    public static function http_host(){
        if (empty($_SERVER['REQUEST_SCHEME']))
            $content = ((strcasecmp($_SERVER['HTTPS'], 'on') == 0) ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].__ROOT__;
        else
            $content = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].__ROOT__;
        
        //return $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].__ROOT__;
        return $content;
    }

    /**
     * curl get 方式获取数据
     * 
     * @param string $url
     */
    public static function curlGet($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (($tmp = curl_exec($ch)) === false) {
            return false;
        }
        curl_close($ch);
        return $tmp;
    }


    public static function curlPost($url, $params) {
        $ssl = substr($url, 0, 8) == "https://" ? TRUE : FALSE;
        $ch = curl_init();
        $paramsStr = '';
        if (!empty($params)) {
            foreach ($params as $k => $v) {
                if (!empty($paramsStr)) {
                    $paramsStr .= "&{$k}={$v}";
                } else {
                    $paramsStr = "{$k}={$v}";
                }
            }
        }
     
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER,FALSE);
        curl_setopt($ch, CURLOPT_NOBODY, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_POST,TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type" => "application/x-www-form-urlencoded"));
        if ($ssl){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名
        }
        if (($returnData = curl_exec($ch)) === false) {
            return false;
        }
        curl_close($ch);
        return $returnData;
    }

    public static function curlJson($url, $json) {
        $ssl = substr($url, 0, 8) == "https://" ? TRUE : FALSE;
        $ch = curl_init();    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER,FALSE);
        curl_setopt($ch, CURLOPT_NOBODY, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_POST,TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json ;charset=utf-8'));
        if ($ssl){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名
        }
        if (($returnData = curl_exec($ch)) === false) {
            return false;
        }
        curl_close($ch);
        return $returnData;
    }




/**********************************************phpExcel*************************************************/

    /**
     * 导出至excel表格
     * @param: $fileName表格名字   $headArr表头  $data导出数据  $msg批注
     */
    public static function getExcel($fileName,$headArr,$data,$msg){
        //对数据进行检验
        if(empty($data) || !is_array($data)){
            die("data must be a array");
        }

        //检查文件名
        if(empty($fileName)){
            die("filename must be existed");
        }

        //获取总列数
        $totalColumn = count($headArr);
        $charColumn = chr($totalColumn + 64);

        $date = date("Y-m-d",time());
        $fileName .= "_{$date}.xls";

        //创建PHPExcel对象
        vendor('PHPExcel.PHPExcel');
        $objPHPExcel = new \PHPExcel();

        //$objProps = $objPHPExcel -> getProperties();
        $objPHPExcel -> setActiveSheetIndex(0); //设置当前的sheet  操作第一个工作表
        $objActSheet = $objPHPExcel -> getActiveSheet();    //添加数据
        $phpstyle = new \PHPExcel_Style_Color();

        //表头变颜色
        $objActSheet -> getStyle('A1:'.$charColumn.'1') -> getFont() -> getColor() -> setARGB($phpstyle::COLOR_BLUE);   //设置颜色

        //设置批注
        $objActSheet -> getStyle('A2') -> getFont() -> getColor() -> setARGB($phpstyle::COLOR_RED);
        $objActSheet -> setCellValue('A2', $msg);   //给单个单元格设置内容
        $objActSheet -> mergeCells('A2:'.$charColumn.'2');  //合并单元格

        //设置表头
        $key = ord("A");
        foreach($headArr as $v){
            $colum = chr($key);
            $objActSheet -> setCellValue($colum.'1', $v);
            $objActSheet -> getColumnDimension($colum) -> setWidth(20);
            $key ++;
        }

        //写入数据
        $column = 3;
        foreach($data as $key => $rows){     //行写入
            $span = ord("A");
            foreach($rows as $keyName => $value){   // 列写入
                $j = chr($span);
                if($keyName !== 'img'){
                    $objActSheet -> setCellValue($j.$column, $value);
                }elseif($keyName == 'img'){
                    $objActSheet -> getRowDimension($column) -> setRowHeight(60);   //设置行高
                    $objDrawing = new \PHPExcel_Worksheet_Drawing();
                    $objDrawing -> setPath($value);
                    $objDrawing -> setWidth(50);
                    $objDrawing -> setHeight(50);
                    $objDrawing -> setCoordinates($j.$column);
                    $objDrawing -> setWorksheet($objPHPExcel->getActiveSheet());
                }
                $span++;
            }
            $column++;
        }


        //处理中文输出问题
        $fileName = iconv("utf-8", "gb2312", $fileName);

        //重命名表
        //$objPHPExcel -> getActiveSheet() -> setTitle('test');

        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        //$objPHPExcel -> setActiveSheetIndex(0);

        //接下来当然是下载这个表格了，在浏览器输出就好了
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter -> save('php://output'); //文件通过浏览器下载
        //exit;
    }

    /**
     * 获取表格数据
     * @param: $fileName表格名字   $headArr表头  $data导出数据  $msg批注
     */
    public static function getData($file_dir){
        vendor('PHPExcel.PHPExcel');
        $PHPReader = new \PHPExcel_Reader_Excel5();

        //载入文件
        $PHPExcel = $PHPReader -> load($file_dir);

        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet = $PHPExcel -> getSheet(0);

        //获取总行数
        $allRow = $currentSheet -> getHighestRow();
        $allColumn = $currentSheet -> getHighestColumn();
        $allColumn = ord($allColumn);

        for($j=2;$j<=$allRow;$j++){
            for($i = 65;$i <= $allColumn;$i++){
                $colum = chr($i);
                $data[$j][$colum] = $PHPExcel -> getActiveSheet() -> getCell($colum.$j)->getValue();
            }
        }
        return $data;
    }







/**********************************************微信相关*************************************************/

    /**
     * 获取access_token
     */
    public static function getaccesstoken($uid){
        $configModel = M('WeixinConfig');
        $config = $configModel -> where(array('uid'=>$uid)) -> find();
        //var_dump( intval($config['access_time'] + 7000),'33333');
        //var_dump($config['access_time']+7000,'llllll');
        //var_dump(time(),'55555');
        $tiems = intval(time() - $config['access_time']);
        
        $ACC_TOKEN = $config['access_token'];
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=$ACC_TOKEN";
        $data = array(                            
                        "scene" => 0,
                        'page' =>   'pages/info/info',
                        //'width'   => 200,
                    );
        $data = json_encode($data);     
        $result = https_post($url,$data);
        $final = json_decode($result,true);
        //print_R($final);exit;
        if(empty($config['access_token']) || $tiems > 7000 || !empty($final['errcode'])){
            $Token = A('Purewechat/Token');
            $res = $Token -> gettoken($config['appid'],$config['appsecret']);
            //$res = $Token -> gettoken('wx12ba3c810e27e52b','2fffd0294007a06d3c491044508d5467');
            $access_token = $res['access_token'];
            $data = array(
                'access_token'  => $access_token,
                'access_time'   => time(),
            );
            $configModel -> where(array('uid'=>$uid))->save($data);
            $date = date("Ymd");
            if(!is_dir("./log/".$date)){
                mkdir("./log/".$date,0755,true);    
            }
            $s = print_r(array($config['access_token'],$tiems,$final), true);                        
            file_put_contents('./log/'.$date.'/'.time().'tiems.log',$s);
        }else{
            //$s = print_r($tiems, true);                        
            //file_put_contents('./log/'.time().'server_date.log',$s);
            $access_token = $config['access_token'];
            
        }

        return $access_token;
    }







/**********************************************curl*************************************************/
    
    public static function httpdata($url,$data){
        $data = json_encode($data);
        //$data = JSON($data, false);

        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $status = curl_exec($ch);
        //var_dump($status,'nininini');die;
        curl_close($ch);
        $res = json_decode($status,true);
        return $res;
    }

    public static function https_request($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)){return 'ERROR '.curl_error($curl);}
        curl_close($curl);
        $data = json_decode($data, true);
        return $data;
    }

    public static function https_post($url,$data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        if (curl_errno($curl)) {
           return 'Errno'.curl_error($curl);
        }
        curl_close($curl);
        return $result;
    }

    /**
     * CURL
     */
    public static function curl($url, $params, $method = 'POST', $cert = array())
    {
        $ch  = curl_init();

        if ('GET' == $method) {
            $url .= '?' . http_build_query($params);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_NOBODY, false);

        if ('POST' == $method) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if (!empty($cert)) {
            curl_setopt($ch, CURLOPT_SSLVERSION, 1);
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, realpath($cert['ssl_cert']));
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, realpath($cert['ssl_key']));
        }

        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        $result = curl_exec($ch);

        curl_close($ch);

        $log_date = date('Y-m-d H:i:s') . ' ';
        $log_file = Yii::getAlias("@runtime") . '/logs/curl.log';
        $log_content = $log_date . 'url: ' . $url;
        if ('POST' == $method) {
            if (is_array($params)) {
                $log_content .= ', params: ' . http_build_query($params);
            } else {
                $log_content .= ', params: ' . str_replace(PHP_EOL, '', $params);
            }
        }
        $log_content .= ', result: ' . $result;

        error_log($log_content . PHP_EOL, 3, $log_file);

        return $result;
    }







/**********************************************log*************************************************/

    /**
     * 将信息记录到文件中
     */
    public static function logs($info){
        $path = RUNTIME_PATH.'Logs/log.log';
        $f = fopen($path, 'w');
        $file = fwrite($f, print_r($info,true));
    }

    public static function log_data($data){
        $date = date("Ymd");
        if(!is_dir("./log/".$date)){
            mkdir("./log/".$date,0755,true);    
        }
        $s = print_r($data, true);                        
        file_put_contents('./log/'.$date.'/'.time().'log_data.log',$s);
    }









/**********************************************文件*************************************************/ 

    //基于数组创建目录和文件
    public static function create_dir_or_files($files){
        foreach ($files as $key => $value) {
            if(substr($value, -1) == '/'){
                mkdir($value);
            }else{
                @file_put_contents($value, '');
            }
        }
    }

    public static function mkDirs($dir){
        if(!is_dir($dir)){
            if(!mkDirs(dirname($dir))){
                return false;
            }
            if(!mkdir($dir,0777)){
                chmod($dir, 0777);
                return false;
            }
        }
        return true;
    }

    /**
     * 格式化字节大小
     * @param  number $size      字节数
     * @param  string $delimiter 数字和单位分隔符
     * @return string            格式化后的带单位的大小
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public static function format_bytes($size, $delimiter = '') {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
        return round($size, 2) . $delimiter . $units[$i];
    }







/**********************************************tree*************************************************/

    /**
     * 把返回的数据集转换成Tree
     * @param array $list 要转换的数据集
     * @param string $pid parent标记字段
     * @param string $level level标记字段
     * @return array
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public static function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId =  $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * 将list_to_tree的树还原成列表
     * @param  array $tree  原来的树
     * @param  string $child 孩子节点的键
     * @param  string $order 排序显示的键，一般是主键 升序排列
     * @param  array  $list  过渡用的中间数组，
     * @return array        返回排过序的列表数组
     * @author yangweijie <yangweijiester@gmail.com>
     */
    public static function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
        if(is_array($tree)) {
            $refer = array();
            foreach ($tree as $key => $value) {
                $reffer = $value;
                if(isset($reffer[$child])){
                    unset($reffer[$child]);
                    tree_to_list($value[$child], $child, $order, $list);
                }
                $list[] = $reffer;
            }
            $list = list_sort_by($list, $order, $sortby='asc');
        }
        return $list;
    }

    public static function array2tree($array, $id = 'id', $pidkey = 'pid', $sonkey = 'son', $pid = 0)
    {
        if(empty($array)) return [];
        //第一步 构造数据
        $items = array();
        foreach($array as $v){
            $items[$v[$id]] = $v;
        }
        //第二部 遍历数据 生成树状结构
        $tree = array();
        foreach($items as $k => $item){
            if(isset($items[$item[$pidkey]])){
                $items[$item[$pidkey]][$sonkey][] = &$items[$k];
            }elseif($item[$pidkey] == $pid) {
                $tree[] = &$items[$k];
            }
        }
        return $tree;
    }


    /**
     * 对查询结果集进行排序
     * @access public
     * @param array $list 查询结果
     * @param string $field 排序的字段名
     * @param array $sortby 排序类型
     * asc正向排序 desc逆向排序 nat自然排序
     * @return array
     */
    public static function list_sort_by($list,$field, $sortby='asc') {
       if(is_array($list)){
           $refer = $resultSet = array();
           foreach ($list as $i => $data)
               $refer[$i] = &$data[$field];
           switch ($sortby) {
               case 'asc': // 正向排序
                    asort($refer);
                    break;
               case 'desc':// 逆向排序
                    arsort($refer);
                    break;
               case 'nat': // 自然排序
                    natcasesort($refer);
                    break;
           }
           foreach ( $refer as $key=> $val)
               $resultSet[] = &$list[$key];
           return $resultSet;
       }
       return false;
    }





/**********************************************加解密*************************************************/

    /**
     * 系统加密方法
     * @param string $data 要加密的字符串
     * @param string $key  加密密钥
     * @param int $expire  过期时间 单位 秒
     * @return string
     */
    public static function think_encrypt($data, $key = '', $expire = 0) {
        $key  = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
        $data = base64_encode($data);
        $x    = 0;
        $len  = strlen($data);
        $l    = strlen($key);
        $char = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        $str = sprintf('%010d', $expire ? $expire + time():0);

        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
        }
        return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
    }

    /**
     * 系统解密方法
     * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
     * @param  string $key  加密密钥
     * @return string
     */
    public static function think_decrypt($data, $key = ''){
        $key    = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
        $data   = str_replace(array('-','_'),array('+','/'),$data);
        $mod4   = strlen($data) % 4;
        if ($mod4) {
           $data .= substr('====', $mod4);
        }
        $data   = base64_decode($data);
        $expire = substr($data,0,10);
        $data   = substr($data,10);

        if($expire > 0 && $expire < time()) {
            return '';
        }
        $x      = 0;
        $len    = strlen($data);
        $l      = strlen($key);
        $char   = $str = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            }else{
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return base64_decode($str);
    }

    /**
     * 数据签名认证
     * @param  array  $data 被认证的数据
     * @return string       签名
     */
    public static function data_auth_sign($data) {
        //数据类型检测
        if(!is_array($data)){
            $data = (array)$data;
        }
        ksort($data); //排序
        $code = http_build_query($data); //url编码并生成query字符串
        $sign = sha1($code); //生成签名
        return $sign;
    }







/**********************************************其他*************************************************/

    /**
     * 格式化手机号-前后各留两位，中间****展示
     * @param  string $mobile 手机号
     * @return string         格式后的手机号
     */ 
    public static function formatMobile($mobile) {
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
    public static function formatIdcard($idcard) {
        $length = strlen($idcard);
        return substr($idcard, 0, 4).'************'.substr($idcard, $length - 4, 4);
    }

    /**
     * 银行卡格式化 前6位 后4位 中间*
     * @param  string $bankCardNo 银行卡号码
     * @return string         
     */
    public static function formatBank($bankCardNo) {
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
     * utf-8和gb2312自动转化
     * @param unknown $string
     * @param string $outEncoding
     * @return unknown|string
     */
    public static function safeEncoding($string,$outEncoding = 'UTF-8')
    {
        $encoding = "UTF-8";
        for($i = 0; $i < strlen ( $string ); $i ++) {
            if (ord ( $string {$i} ) < 128)
                continue;
    
            if ((ord ( $string {$i} ) & 224) == 224) {
                // 第一个字节判断通过
                $char = $string {++ $i};
                if ((ord ( $char ) & 128) == 128) {
                    // 第二个字节判断通过
                    $char = $string {++ $i};
                    if ((ord ( $char ) & 128) == 128) {
                        $encoding = "UTF-8";
                        break;
                    }
                }
            }
            if ((ord ( $string {$i} ) & 192) == 192) {
                // 第一个字节判断通过
                $char = $string {++ $i};
                if ((ord ( $char ) & 128) == 128) {
                    // 第二个字节判断通过
                    $encoding = "GB2312";
                    break;
                }
            }
        }
    
        if (strtoupper ( $encoding ) == strtoupper ( $outEncoding ))
            return $string;
        else
            return @iconv ( $encoding, $outEncoding, $string );
    }

    /**
     * 判断当前服务器系统
     * @return string
     */
    public static function getOS(){
        if(PATH_SEPARATOR == ':'){
            return 'Linux';
        }else{
            return 'Windows';
        }
    }

    /**
     * 获取设备信息 0 pc 以及其他  1. iOS 2.Android
     */
    public static function getDeviceType() {
        if(stripos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||stripos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            return 1;
        }else if(stripos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            return 2;
        }else{
            return 0;
        }
    }

    public static function getClientIp() {
        $unknown = 'unknown';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        //处理多层代理的情况,或者使用正则方式：$ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
        if (false !== strpos($ip, ',')) {
            $ip = reset(explode(',', $ip));
        }
        return $ip;
    }
}
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

    
}
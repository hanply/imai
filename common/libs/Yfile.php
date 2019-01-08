<?php
namespace common\libs;
/**********************************************文件*************************************************/ 
class Yfile
{
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
}
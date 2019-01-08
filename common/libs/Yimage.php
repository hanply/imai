<?php
namespace common\libs;
/**********************************************图片*************************************************/

class Yimage
{
    
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
}
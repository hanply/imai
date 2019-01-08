<?php
namespace libs;
/**
 * 加密类
 */
class Yauth 
{
    public $type        = 'discuz';
    public $config      =  [];

    public $rsaPublicKey    = '';
    public $rsaPrivateKey   = '';

    static public $dbs      =  array();

    public function __construct($config=[]){
        if(empty($config)){
            $this->config = config('auth');
        }else{
            $this->config = $config;
        }
        $this->type =  $this->config['type'] ;
        if( $this->type == 'rsa' ){
            if( $this->config['keytype'] == 'file' ){
                $this->rsaPublicKey     =  file_get_contents( $this->config['publickey'] );
                $this->rsaPrivateKey    =  file_get_contents( $this->config['privatekey'] );
            }else{
                $this->rsaPublicKey     = $this->config['publickey'];
                $this->rsaPrivateKey    = $this->config['privatekey'] ;
            }
        }
    }
    static public function m(  $config = 'default' ){
        if( !isset( self::$dbs[$config] )  ){
            $class = __CLASS__ ;
            self::$dbs[$config] =  new $class( );
        }
        return self::$dbs[$config];
    }

    public function decode( $string ){
        $a = $this->type.'_decode';
        return $this->$a( $string );
    }

    public function encode( $string , $expiry =0 ){
        $a = $this->type.'_encode';
        return $this->$a( $string ,  $expiry );
    }

    // 康盛双向加解密算法

    private function discuz_decode( $string  ,$expiry =0){
        return $this->discuz( $string , 'DECODE' , $this->config['key'] , $expiry );
    }

    private function discuz_encode( $string ,  $expiry = 0 ){
        return $this->discuz( $string , 'ENCODE' , $this->config['key'] , $expiry );
    }
    private function discuz($string, $operation = 'DECODE', $key = '', $expiry = 0) {  
        $ckey_length = 4;  
        $key    = md5($key );  
        $keya   = md5(substr($key, 0, 16));  
        $keyb   = md5(substr($key, 16, 16));  
        $keyc   = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';  
        $cryptkey   = $keya.md5($keya.$keyc);  
        $key_length = strlen($cryptkey);  
        $string     = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;  
        $string_length = strlen($string);  
        $result = '';  
        $box = range(0, 255);  
        $rndkey = array();  
        for($i = 0; $i <= 255; $i++) {  
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);  
        }  
        for($j = $i = 0; $i < 256; $i++) {  
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;  
            $tmp = $box[$i];  
            $box[$i] = $box[$j];  
            $box[$j] = $tmp;  
        }  
        for($a = $j = $i = 0; $i < $string_length; $i++) {  
            $a = ($a + 1) % 256;  
            $j = ($j + $box[$a]) % 256;  
            $tmp = $box[$a];  
            $box[$a] = $box[$j];  
            $box[$j] = $tmp;  
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));  
        }  
        if($operation == 'DECODE') {  
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {  
                return substr($result, 26);  
            } else {  
                return '';  
            }  
        } else {  
            return $keyc.str_replace('=', '', base64_encode($result));  
        }  
    }

    // 3des

    private function thirddes_encode( $input ,  $expiry = 0){
        $size = mcrypt_get_block_size('tripledes', 'ecb');
        $input = $this->thirddes_pkcs5_pad($input, $size); //pkcs5填充方式
        $key = base64_decode( $this->config['key']);
        $td = mcrypt_module_open( MCRYPT_3DES, '', MCRYPT_MODE_ECB, '');  
        //使用MCRYPT_3DES算法,ecb模式
        mcrypt_generic_init($td, $key,  $this->config['authecbcode']);
        //初始处理
        $data = mcrypt_generic($td, $input);
        //加密
        mcrypt_generic_deinit($td);
        //结束
        mcrypt_module_close($td);
        $data = $this->thirddes_removeBR(base64_encode($data));
        return $data;
    }
    private function thirddes_decode(){
        $encrypted = base64_decode($encrypted);
        $key = base64_decode($this->config['key']);
        $td = mcrypt_module_open( MCRYPT_3DES,'',MCRYPT_MODE_ECB,'');
        //使用MCRYPT_3DES算法,ecb模式
        mcrypt_generic_init($td, $key, $this->config['authecbcode']);
        //初始处理
        $decrypted = mdecrypt_generic($td, $encrypted);
        //解密
        mcrypt_generic_deinit($td);
        //结束
        mcrypt_module_close($td);
        $decrypted = $this->thirddes_pkcs5_unpad($decrypted); //pkcs5填充方式
        return $decrypted;
    }

    //删除回车和换行
    private  function thirddes_removeBR( $str ){
        $len = strlen( $str );
        $newstr = "";
        $str = str_split($str);
        for ($i = 0; $i < $len; $i++ ){
            if ($str[$i] != '\n' and $str[$i] != '\r'){
                $newstr .= $str[$i];
            }
        }
        return $newstr;
    }

    private function thirddes_pkcs5_pad($text, $blocksize){
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    private  function thirddes_pkcs5_unpad($text){
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
        return substr($text, 0, -1 * $pad);
    }

    // rsa
    private function rsa_decode( $data ){
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->rsaPrivateKey)){
            $data = $decrypted;  
        }else {
            $data = ''; 
        } 
        return $data;
    }
    private function rsa_encode( $data , $expiry = 0 ){
        if (openssl_public_encrypt($data, $encrypted, $this->rsaPublicKey ) ) {
            $data = base64_encode($encrypted); 
        }else{
            throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?'); 
        }  
        return $data; 
    } 
    //RSA 实现生成公私密钥
    static public function rsa_keycreate(){
        $res = openssl_pkey_new();
        openssl_pkey_export($res,$pri);
        $d   = openssl_pkey_get_details($res);
        $pub = $d['key'];
        return array('privatekey'=>$pri , 'publickey'=>$pub);
    }
   
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;

class TestController extends Controller
{
    public function encrypt(){ 
        //加密
        //ord     转换字符串第一个字节为 0-255 之间的值
        $str = "WDNMDzxw";
        echo "原文:". $str;echo "<br>";
        $length = strlen($str); //获取字符串长度
        echo "lengt:".$length;echo '<hr>';
        $new_str = '';
        for($i=0;$i<$length;$i++){
            echo $str[$i] . '>' . ord($str[$i]);echo "<br>";
            $code = ord($str[$i]) + 1;
            echo "编码 $str[$i]".'>'.$code .'>'. chr($code);echo "<br>";
            $new_str .= chr($code);

        }
        echo '<hr>';
        echo "密文:". $new_str;echo "<br>";

        $url = 'http://api.1906.com/decrypt?data='.$new_str;
        $response = file_get_contents($url);
        var_dump($response);
    }
    public function decrypt2(){
        //解密
        // $data = 'XEONE{yx';
        // echo "密文:".$data;echo "<br>";
        // $length = strlen($data);
        // $str = '';
        // for($i=0;$i<$length;$i++){
        //     echo $data[$i] . '>' .ord($data[$i]);echo "<br>";
        //     $code =ord($data[$i]) - 1;
        //     //echo "<hr>";
        //     echo "解码:" .$data[$i] . '>'. chr($code);echo "<br>";
        //     $str .= chr($code);
        // }
        // echo "解密后数据:".$str;
        $key="1906phpa";
        $method = 'aes-128-cbc';
        $iv = 'adadaweaa1234567';
        echo "接收到的数据:";echo "<br>";
        echo "<pre>";print_r($_GET);echo "</pre>";
        $data = $_GET['data'];

        $dec_data = openssl_decrypt($enc_str,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo "解密的数据:";echo "<br>";
        var_dump($dec_data);
    }
    public function encrypt1(){
        // $method_arr=openssl_get_cipher_methods();
        // echo "<pre>";print_r($method_arr);echo "</pre>";
        // die;
        $key = '1906phpa';

        $data = "WDNMD"; //要进行加密的数据
        $method = 'aes-128-cbc';
        $iv = 'adadaweaa1234567'; //iv必须为16个字节
        $enc_str = openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo "原始数据:".$data;echo "<br>";
        echo "加密后密文:" .$enc_str;echo "<br>";
        $base64_str = base64_encode($enc_str);
        echo "base64编译后的密文:".$base64_str;

  
        //将加密后的数据发送到decrypt2
        $url = 'http://api.1906.com/test/decrypt2?data='.$enc_str;
        $response = file_get_contents($url);
        var_dump($response);
        // $ch=curl_init();
        // curl_setopt($ch,CURLOPT_URL,$url);
        // curl_setopt($ch,CURLOPT_HEADER,0);
        // curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        // $result=curl_exec($ch);
        // var_dump($ch);
       
    }
    public function rsa(){
        $data = "yysy,qs";

        $key = file_get_contents(storage_path('keys/pub_a.key'));
        //echo $key;die;
        //加密
        openssl_public_encrypt($data,$enc_data,$key);
        var_dump($enc_data);echo "<br>";

        $send_data = base64_encode($enc_data);
        //把编译后的加密数据发送给A

        $url = 'http://api.1906.com/rsa/decrypt1?data='.urlencode($send_data);
        $response = file_get_contents($url);
        var_dump($response);

    }
}

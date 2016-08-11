<?php
/**
 * 互亿无线短信类
 *
 * User: 廖
 * Date: 16/8/10
 * Time: 下午8:02
 */
class Huyi {

    var $url;

    var $account;

    var $password;

    function __construct($url, $account, $password) {
        $this->url = $url;
        $this->account = $account;
        $this->password = $password;
    }

    function sendSMS($mobile, $content) {
        $post_data = "account=". $this->account
            . "&password=" . $this->password
            . "&mobile=" . $mobile
            . "&content=" . rawurlencode($content);

        //密码可以使用明文密码或使用32位MD5加密
        return $this->xmlToArray($this->doPost($post_data, $this->url));
    }

    private function doPost($curlPost,$url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }

    private function xmlToArray($xml){
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        $arr = array();
        if(preg_match_all($reg, $xml, $matches)){
            $count = count($matches[0]);
            for($i = 0; $i < $count; $i++){
                $subxml= $matches[2][$i];
                $key = $matches[1][$i];
                if(preg_match( $reg, $subxml )){
                    $arr[$key] = $this->xmlToArray($subxml);
                }else{
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }
}
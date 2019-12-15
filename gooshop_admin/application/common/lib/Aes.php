<?php
namespace app\common\lib;

class AES {
    /**
     *密钥
     */
    public $key='123a456b789c123d';
    public $options=0;
    /**
     * aes加密
     * @param string $string 需要加密的字符串
     * @param string $key 密钥
     * @return string
     */
    public function encrypt($string)
    {  
        $data = openssl_encrypt($string, 'AES-128-ECB', $this->key,$this->options);
        return $data;
    }


    /**
     * aes解密
     * @param string $string 需要解密的字符串
     * @param string $key 密钥
     * @return string
     */
    public function decrypt($string)
    {
        $decrypted = openssl_decrypt($string, 'AES-128-ECB', $this->key,$this->options);
        return $decrypted;
    }

}

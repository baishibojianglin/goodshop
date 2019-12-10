<?php
namespace app\index\controller;
use app\common\lib\Aes;

class Login
{
	/**
	*后台登录
	*/
    public function login()
    {
      $value=input();

      //解密类实例化
      $aes=new Aes();
      //解密sign
      $sign=$aes->decrypt($value['sign']);
      if($sign!='jl_goodshop'){
        $result['status']=0;
        $result['message']='验签不正确';
        return json($result);
      }
      //解密账号和密码
      $str=$aes->decrypt($value['str']);
      //字符串分解成变量
      parse_str($str,$data);
      //验证账号是否为空
      if(empty($data['account'])){
        $result['status']=0;
        $result['message']='请填写账号';
        return json($result);     	
      }
      //验证密码是否为空
      if(empty($data['password'])){
        $result['status']=0;
        $result['message']='请填写密码';
        return json($result);     	
      }
      //验证验证码是否为空
      if(empty($data['verifycode'])){
        $result['status']=0;
        $result['message']='请填写验证码';
        return json($result);     	
      }
      //密码md5加密
      $data['password']=md5($data['password']);
	    //查询数据表模型类
	    $list=model('Companyuser')->checklogin($data['account'],$data['password']);
      if(!empty($list)){
        return json($list); 
      }
      
      
    }
}

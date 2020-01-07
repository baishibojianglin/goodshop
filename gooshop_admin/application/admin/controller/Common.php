<?php
namespace app\admin\controller;
use app\admin\model\Companyuser;
use think\Request;


class Common extends Controller
{

  /**
  *初始化方法
  */  
  public function _initialize(){
    //调用检查操作是否合法和登录是否过期
    $this->loginstatus();
  }


  /**
  *检查操作是否合法和登录是否过期
  */
    public function loginstatus()
    {
       $header=request()->header();
       $lsit=model('Companyuser')->loginstatus();   
       //验证token
       if(empty($lsit)){
         return false;
       }
       //验证过期时间
       $time=time();
       if($time-$lsit['tokentime']>3600*24){
         return false;      
       }  
       //验证通过,重置过期时间     
       model('Companyuser')->setlogintime();
       return true;
              
    }


}

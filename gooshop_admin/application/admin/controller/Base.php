<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

/**
 * admin模块登录授权基础控制器类
 * Class Base
 * @package app\admin\controller
 */
class Base extends Common
{
    /**
     * 初始化方法
     */
    public function _initialize()
    {
        // 判断是否登录
        if (!($this->$this->loginstatus())) {
            return show(config('code.error'), '未登录', '', 401);
        }
    }

    /**
     * 检查操作是否合法和登录是否过期
     * @return bool
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

    /**
     * 上传图片
     */
    public function test(){
        $file = request()->file('zhizhao');
    }



}

<?php
namespace app\index\model;
use think\Model;

/**
 * 分公司模型类
 */
class Companyuser extends  Model
{
    /**
	 * 分公司登录
	 */ 
	 public function checklogin($count,$password){
         $map['count']=$count;
         $map['password']=$password;
         $list=$this->where($map)->find();
         return $list;
	 }   
}



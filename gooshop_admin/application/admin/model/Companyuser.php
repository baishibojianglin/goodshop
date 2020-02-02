<?php
namespace app\admin\model;
use think\Model;

/**
 * 分公司模型类
 */
class Companyuser extends  Model
{
    /**
    *表前缀
    */
    protected $connection = ['prefix'=>'goodshop_'];

    /**
     * 分公司登录
     * @param $account
     * @param $password
     * @return array|false|\PDOStatement|string|Model
     */
	 public function checklogin($account, $password){
         $map['account'] = $account;
         $map['password'] = $password;
         $map['status'] = config('code.status_enable'); // 启用状态
         $list=$this->where($map)->field('password,tokentime',true)->find();
         return $list;
	 }  
    /**
	 * 存入token到分公司用户表
	 */ 
	 public function savetoken($id,$token){
         $map['id']=$id;
         $data['token']=$token;
         $data['tokentime']=time();
         $list=$this->save($data,$map);
         return $list;
	 } 
    /**
     * 检查用户登录状态
     */ 
     public function loginstatus($token){
         $map['token']=$token;
         $list=$this->where($map)->find();
         return $list;
     }
    /**
     * 重置登录过期时间
     */ 
     public function setlogintime($token){
         $map['token']=$token;
         $data['tokentime']=time();
         $list=$this->save($data,$map);
     } 

     	  
}



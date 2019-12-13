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
	 public function checklogin($account,$password){
         $map['account']=$account;
         $map['password']=$password;
         $list=$this->where($map)->find();
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
}



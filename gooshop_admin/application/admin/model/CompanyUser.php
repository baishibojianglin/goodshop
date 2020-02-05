<?php

namespace app\admin\model;

use think\Model;

/**
 * 供应商用户模型类
 * Class CompanyUser
 * @package app\admin\model
 */
class CompanyUser extends Base
{
    /**
     * 表前缀
     */
    protected $connection = ['prefix' => 'goodshop_'];

    /**
     * 供应商用户登录
     * @param $account
     * @param $password
     * @return array|false|\PDOStatement|string|Model
     */
    public function checklogin($account, $password)
    {
        $map['account|phone'] = $account;
        $map['password'] = $password;
        $map['status'] = config('code.status_enable'); // 启用状态
        $list = $this->where($map)->field('password,token_time', true)->find();
        return $list;
    }

    /**
     * 存入token到供应商用户表
     * @param $id
     * @param $token
     * @return false|int
     */
    public function savetoken($id, $token)
    {
        $map['user_id'] = $id;
        $data['token'] = $token;
        $data['token_time'] = time();
        $list = $this->save($data, $map);
        return $list;
    }

    /**
     * 检查用户登录状态
     * @param $token
     * @return array|false|\PDOStatement|string|Model
     */
    public function loginstatus($token)
    {
        $map['token'] = $token;
        $list = $this->where($map)->find();
        return $list;
    }

    /**
     * 重置登录过期时间
     * @param $token
     */
    public function setlogintime($token){
        $map['token'] = $token;
        $data['token_time'] = time();
        $list = $this->save($data, $map);
    }
}

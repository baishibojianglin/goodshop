<?php

namespace app\admin\model;
use think\Model;

/**
 * 供应商信息模型类
 * Class Company
 * @package app\admin\model
 */
class Company
{
    /**
     * 表前缀
     */
    protected $connection = ['prefix' => 'goodshop_'];

    /**
     * 创建供应商
     * @param {object} 
     */
    public function checklogin($account, $password)
    {
        $map['account|phone'] = $account;
        $map['password'] = $password;
        $map['status'] = config('code.status_enable'); // 启用状态
        $list = $this->where($map)->field('password,token_time', true)->find();
        return $list;
    }


}

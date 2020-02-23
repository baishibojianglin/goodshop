<?php

namespace app\admin\model;

use think\Model;

/**
 * 供应商信息模型类
 * Class Company
 * @package app\admin\model
 */
class Company extends Base
{
    /**
     * 表前缀
     */
    protected $connection = ['prefix' => 'goodshop_'];

    /**
     * 创建供应商
     * @param $data
     */
    public function inCompany($data)
    {
        //入库供应商基本信息表

        $data['role']=1;  //供应商
        $data['status']=2; //草稿
        $data['type']=1; //正式数据
        $data['create_time']=date('Y-m-d H:i:s');
        $list=$this->save($data);
        return $this->id;

    }


    /**
     * 获取供应商销售区域字段
     * @param $data
     */
    public function salearea($data)
    {
        //入库供应商基本信息表

        $list=$this->where($data)->value('salearea');
        return $list;

    }


}

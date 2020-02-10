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
<<<<<<< HEAD
=======
     * @param {object}
     * @return array|false|\PDOStatement|string|Model
>>>>>>> 66cd755b4c00ce39fd848d541829a689a6d9a694
     */
    public function inCompany($data)
    {
        //入库供应商基本信息表
        $this->save([
            'name'= $data['name'];  
            'address' = $data['address'];
            'role' = 1;
            'upid' =  $data['upid'];
            'status' =  1;
            'type' =  1;
            'license_creditcode' =  $data['license_creditcode'];
            'url_license' =  $data['url_license'];
            'legalperson_name' =  $data['legalperson_name'];
            'url_idcard' =  $data['url_idcard'];
            'legalperson_idcard_code' =  $data['legalperson_idcard_code'];
        ]);



        //return $data;


    }


}

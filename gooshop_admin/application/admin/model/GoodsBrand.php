<?php

namespace app\admin\model;

use think\Model;

/**
 * 商品品牌模型类
 * Class GoodsBrand
 * @package app\common\model
 */
class GoodsBrand extends Base
{
    /**
     * 获取商品品牌列表数据
     * @param array $map
     * @param int $size
     * @return \think\Paginator
     */
    public function getGoodsBrand($map = [], $size = 5)
    {
        $result = $this->alias('gb')
            ->field($this->_getListField())
            ->join('__COMPANYUSER__ cu', 'gb.company_id = cu.id', 'LEFT') // 创建者
            ->where($map)->cache(true, 10)->paginate($size);
        return $result;
    }

    /**
     * 通用化获取参数的数据字段
     * @return array
     */
    private function _getListField()
    {
        return [
            'gb.brand_id',
            'gb.brand_name',
            'gb.logo',
            'gb.company_id',
            'gb.create_time',
            'gb.audit_id',
            'gb.audit_status',
            'gb.audit_time',
            'cu.name create_name'
        ];
    }
}

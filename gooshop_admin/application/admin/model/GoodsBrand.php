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
        $result = $this->field('desc', true)->where($map)->cache(true, 10)->paginate($size);
        return $result;
    }
}

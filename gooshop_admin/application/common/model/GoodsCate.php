<?php

namespace app\common\model;

use think\Model;

/**
 * 商品类别模型类
 * Class GoodsCate
 * @package app\common\model
 */
class GoodsCate extends Base
{
    /**
     * 获取商品类别列表数据
     * @param array $map
     * @return \think\Paginator
     */
    public function getGoodsCate($map = [])
    {
        if(!isset($map['parent_id'])) { // 父级ID
            $map['parent_id'] = 0;
        }

        $result = $this->where($map)->select();
        return $result;
    }
}

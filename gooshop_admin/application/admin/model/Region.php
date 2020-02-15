<?php

namespace app\admin\model;

use think\Model;

/**
 * 区域模型类
 * Class Region
 * @package app\common\model
 */
class Region extends Base
{
    /**
     * 获取区域列表数据
     * @param array $map
     * @return \think\Paginator
     */
    public function getRegion($map = [])
    {
        if(!isset($map['level'])) { // 区域级别
            $map['level'] = 1;
        }

        $result = $this->where($map)->cache(true, 10)->select();
        return $result;
    }



}

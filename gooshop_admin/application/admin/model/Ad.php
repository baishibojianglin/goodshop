<?php

namespace app\admin\model;

use think\Model;

/**
 * 广告模型类
 * Class Ad
 * @package app\common\model
 */
class Ad extends Base
{
    /**
     * 获取广告列表数据（基于paginate()自动化分页）
     * @param array $map
     * @param $order
     * @param int $size
     * @return \think\Paginator
     */
    public function getAd($map = [], $order, $size = 5)
    {
        if(!isset($map['a.is_delete'])) {
            $map['a.is_delete'] = ['neq', config('code.is_delete')];
        }

        if(!isset($order)) { // 排序
            $order = ['a.ad_id' => 'asc'];
        }

        $result = $this->alias('a')
            ->field('a.*, ap.position_name, c.name company_name, cu.user_name')
            ->join('__AD_POSITION__ ap', 'a.position_id = ap.position_id', 'LEFT') // 广告位
            ->join('__COMPANY__ c', 'a.company_id = c.id', 'LEFT') // 广告所属供应商
            ->join('__COMPANY_USER__ cu', 'a.user_id = cu.user_id', 'LEFT') // 广告创建者
            ->where($map)
            ->order($order)
            ->paginate($size);
        return $result;
    }
}

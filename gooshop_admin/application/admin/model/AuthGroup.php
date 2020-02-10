<?php

namespace app\admin\model;

use think\Model;

/**
 * Auth权限认证用户组模型类
 * Class AuthGroup
 * @package app\common\model
 */
class AuthGroup extends Base
{
    /**
     * 获取Auth用户组列表数据（基于paginate()自动化分页）
     * @param array $map
     * @param int $size
     * @return \think\Paginator
     */
    public function getAuthGroup($map = [], $size = 5)
    {
        /*if(!isset($map['is_delete'])) {
            $map['is_delete'] = ['neq', config('code.is_delete')];
        }*/

        $order = ['ag.id' => 'asc'];

        $result = $this->alias('ag')
            ->field('ag.*, pag.title parent_title')
            ->join('__AUTH_GROUP__ pag', 'ag.parent_id = pag.id', 'LEFT')
            ->where($map)
            ->order($order)
            ->paginate($size);
        return $result;
    }
}

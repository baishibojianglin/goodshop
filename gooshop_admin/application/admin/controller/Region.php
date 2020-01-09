<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

/**
 * admin模块区域管理控制器类
 * Class Region
 * @package app\admin\controller
 */
class Region extends Controller
{
    /**
     * 显示区域资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 判断为GET请求
        if (request()->isGet()) {
            // 传入的参数
            $param = input('param.');
            $query = http_build_query($param); // 生成 URL-encode 之后的请求字符串 //halt($query);

            // 查询条件
            $map = [];
            if (!empty($param['region_name'])) { // 区域名称
                $map['region_name'] = trim($param['region_name']);
            }
            if (isset($param['level'])) { // 区域级别
                $map['level'] = intval($param['level']);
            }
            if (isset($param['parent_id'])) { // 上级ID
                $map['parent_id'] = intval($param['parent_id']);
            }

            // 获取区域列表数据
            try {
                $data = model('Region')->getRegion($map);
            } catch (\Exception $e) {
                return show(config('code.error'), $e->getMessage());
            }

            return show(config('code.success'), 'OK', $data);
        } else {
            return show(config('code.error'), '请求不合法', [], 400);
        }
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}

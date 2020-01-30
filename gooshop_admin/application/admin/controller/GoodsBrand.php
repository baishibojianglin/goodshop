<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

/**
 * admin模块商品品牌管理控制器类
 * Class GoodsBrand
 * @package app\admin\controller
 */
class GoodsBrand extends Base
{
    /**
     * 显示商品品牌资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        // 判断为GET请求
        if (request()->isGet()) {
            // 传入的参数
            $param = input('param.');

            // 查询条件
            $map = [];
            if (!empty($param['brand_name'])) { // 商品品牌名称
                $map['brand_name'] = ['like', '%' . trim($param['brand_name']) . '%'];
            }
            if (isset($param['size'])) { // 每页条数
                $param['size'] = intval($param['size']);
            }

            // 获取分页page、size
            $this->getPageAndSize($param);

            // 获取商品品牌列表数据
            try {
                $data = model('GoodsBrand')->getGoodsBrand($map, $this->size);
            } catch (\Exception $e) {
                return show(config('code.error'), '网络忙，请重试', [], 500); // $e->getMessage()
            }

            if ($data) {
                // 处理数据
                $auditStatus = config('code.audit_status'); // 审核状态：0待审核，1通过，2驳回
                foreach ($data as $key => $value) {
                    $data[$key]['audit_status_msg'] = $auditStatus[$value['audit_status']]; // 定义审核状态信息
                }

                return show(config('code.success'), 'OK', $data);
            } else {
                return show(config('code.error'), 'Not Found', $data, 404);
            }
        } else {
            return show(config('code.error'), '请求不合法', [], 400);
        }
    }

    /**
     * 保存新建的商品品牌资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        // 判断为POST请求
        if(request()->isPost()){
            $data = input('post.');

            // validate验证数据合法性
            $validate = validate('GoodsBrand');
            if (!$validate->check($data)) {
                return show(config('code.error'), $validate->getError(), [], 403);
            }

            // 入库操作
            try {
                $id = model('GoodsBrand')->add($data, 'cate_id');
            } catch (\Exception $e) {
                return show(config('code.error'), '网络忙，请重试', [], 500); // $e->getMessage()
            }
            if ($id) {
                return show(config('code.success'), '新增成功', ['cate_id' => $id], 201);
            } else {
                return show(config('code.error'), '新增失败', [], 403);
            }
        } else {
            return show(config('code.error'), '请求不合法', [], 400);
        }
    }

    /**
     * 显示指定的商品品牌资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        // 判断为GET请求
        if (request()->isGet()) {
            try {
                $data = model('GoodsBrand')->find($id);
            } catch (\Exception $e) {
                return show(config('code.error'), '网络忙，请重试', [], 500); // $e->getMessage()
            }

            if ($data) {
                return show(config('code.success'), 'ok', $data);
            } else {
                return show(config('code.error'), 'Not Found', $data, 404);
            }
        } else {
            return show(config('code.error'), '请求不合法', [], 400);
        }
    }

    /**
     * 保存更新的商品品牌资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        // 判断为PUT请求
        if (request()->isPut()) {
            // 传入的数据
            $param = input('param.');

            // validate验证数据合法性：判断是审核状态还是更新其他数据
            $validate = validate('GoodsBrand');
            $rules = [];
            $scene = 'update';
            if (isset($param['audit_status'])) {
                $rules = ['audit_status' => 'require'];
                $scene = [];
            }
            if (!$validate->check($param, $rules, $scene)) {
                return show(config('code.error'), $validate->getError(), [], 403);
            }

            // 判断数据是否存在
            $data = [];
            if (!empty($param['brand_name'])) { // 商品品牌名称
                $data['brand_name'] = trim($param['brand_name']);
            }
            if (isset($param['sort'])) { // 排序
                $data['sort'] = input('param.sort', null, 'intval');
            }
            if (isset($param['audit_status'])) { // 审核状态
                $data['audit_status'] = input('param.audit_status', null, 'intval');
            }

            if (empty($data)) {
                return show(config('code.error'), '数据不合法', [], 404);
            }

            // 更新
            try {
                $result = model('GoodsBrand')->save($data, ['cate_id' => $id]); // 更新
            } catch (\Exception $e) {
                return show(config('code.error'), '网络忙，请重试', [], 500); // $e->getMessage()
            }
            if (false === $result) {
                return show(config('code.error'), '更新失败', [], 403);
            } else {
                return show(config('code.success'), '更新成功', [], 201);
            }
        } else {
            return show(config('code.error'), '请求不合法', [], 400);
        }
    }

    /**
     * 删除指定商品品牌资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        // 判断为DELETE请求
        if (request()->isDelete()) {
            // 获取指定的商品品牌
            try {
                $data = model('GoodsBrand')->find($id);
            } catch (\Exception $e) {
                return show(config('code.error'), '网络忙，请重试', [], 500); // $e->getMessage()
            }

            // 判断数据是否存在
            if ($data['cate_id'] != $id) {
                return show(config('code.error'), '数据不存在');
            }

            // 判断删除条件：判断是否存在下级商品品牌
            $goodsCateList = model('GoodsCate')->where(['parent_id' => $id])->select();
            if (!empty($goodsCateList)) {
                return show(config('code.error'), '删除失败：存在下级商品品牌', [], 403);
            }

            // 真删除
            try { // 捕获异常
                $result = model('GoodsBrand')->destroy($id);
            } catch (\Exception $e) {
                return show(config('code.error'), '网络忙，请重试', [], 500); // $e->getMessage()
            }
            if (!$result) {
                return show(config('code.error'), '删除失败', [], 403);
            } else {
                return show(config('code.success'), '删除成功', []);
            }
        } else {
            return show(config('code.error'), '请求不合法', [], 400);
        }
    }
}

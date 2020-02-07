<?php

namespace app\admin\controller;

use app\common\lib\exception\ApiException;
use think\Controller;
use think\Request;

/**
 * admin模块供应商用户控制器类
 * Class CompanyUser
 * @package app\admin\controller
 */
class CompanyUser extends Base
{
    /**
     * 显示供应商用户资源列表
     * @return \think\response\Json
     */
    public function index()
    {
        // 判断为GET请求
        if (request()->isGet()) {
            // 传入的数据
            $param = input('param.');
            if (isset($param['size'])) { // 每页条数
                $param['size'] = intval($param['size']);
            }

            // 查询条件
            $map = [];
            if (!empty($param['user_name'])) {
                $map['cu.user_name'] = ['like', '%' . $param['user_name'] . '%'];
            }

            // 获取分页page、size
            $this->getPageAndSize($param);

            // 获取分页列表数据 模式一：基于paginate()自动化分页
            try {
                $data = model('CompanyUser')->getCompanyUser($map, $this->size);
            } catch (\Exception $e) {
                return show(config('code.error'), '网络忙，请重试', '', 500); // $e->getMessage()
            }
            $status = config('code.status');
            foreach ($data as $key => $value) {
                $data[$key]['status_msg'] = $status[$value['status']];
            }
            return show(config('code.success'), 'OK', $data);
        } else {
            return show(config('code.error'), '请求不合法', '', 400);
        }
    }

    /**
     * 保存新建的供应商用户资源
     * @param Request $request
     * @return \think\response\Json
     * @throws ApiException
     */
    public function save(Request $request)
    {
        // 判断为POST请求
        if (request()->isPost()) {
            // 传入的数据
            $data = input('post.');

            // validate验证
            $validate = validate('CompanyUser');
            if (!$validate->check($data)) {
                return show(config('code.error'), $validate->getError(), [], 403);
            }

            // 处理数据
            $data['status'] = isset($data['status']) ? $data['status'] : config('code.status_disable');
            $data['rules'] = isset($data['rules']) ? implode(',', $data['rules'] = [1,2,3,4]) : '';

            // 新增
            // 捕获异常
            try {
                $id = model('CompanyUser')->add($data, 'user_id'); // 新增
            } catch (\Exception $e) {
                return show(config('code.error'), '网络忙，请重试', '', 500);
            }
            // 判断是否新增成功：获取id
            if ($id) {
                return show(config('code.success'), '供应商用户新增成功', [], 201);
            } else {
                return show(config('code.error'), '供应商用户新增失败', [], 403);
            }
        } else {
            return show(config('code.error'), '请求不合法', '', 400);
        }
    }

    /**
     * 显示指定的供应商用户资源
     * @param int $id
     * @return \think\response\Json
     * @throws ApiException
     */
    public function read($id)
    {
        // 判断为GET请求
        if (request()->isGet()) {
            try {
                $data = model('CompanyUser')->find($id);
            } catch (\Exception $e) {
                return show(config('code.error'), '网络忙，请重试', '', 500);
            }

            if ($data) {
                // 处理数据
                // 定义status_msg
                $status = config('code.status');
                $data['status_msg'] = $status[$data['status']];

                return show(config('code.success'), 'ok', $data);
            }
        } else {
            return show(config('code.error'), '请求不合法', '', 400);
        }
    }

    /**
     * 保存更新的供应商用户资源
     * @param Request $request
     * @param int $id
     * @return \think\response\Json
     * @throws ApiException
     */
    public function update(Request $request, $id)
    {
        // 传入的数据
        $param = input('param.');

        // validate验证
        $validate = validate('CompanyUser');
        if (!$validate->check($param, [], '')) {
            return show(config('code.error'), $validate->getError(), [], 403);
        }

        // 判断数据是否存在
        $data = [];
        if (!empty($param['title'])) {
            $data['title'] = $param['title'];
        }
        if (isset($param['status'])) { // 不能用 !empty() ，否则 status = 0 时也判断为空
            $data['status'] = input('param.status', null, 'intval');
        }
        if (!empty($param['rules'])) {
            $data['rules'] = implode(',', $param['rules']);
        }

        if (empty($data)) {
            return show(config('code.error'), '数据不合法', [], 404);
        }

        // 更新
        try {
            $result = model('CompanyUser')->save($data, ['id' => $id]); // 更新
        } catch (\Exception $e) {
            return show(config('code.error'), '网络忙，请重试', '', 500);
        }
        if (false === $result) {
            return show(config('code.error'), '更新失败', [], 403);
        } else {
            return show(config('code.success'), '更新成功', [], 201);
        }
    }

    /**
     * 删除指定供应商用户资源
     * @param int $id
     * @return \think\response\Json
     * @throws ApiException
     */
    public function delete($id)
    {
        // 显示指定的店鋪比赛场次模板
        try {
            $data = model('CompanyUser')->find($id);
            //return show(config('code.success'), 'ok', $data);
        } catch (\Exception $e) {
            return show(config('code.error'), '网络忙，请重试', '', 500);
            //throw new ApiException($e->getMessage(), 500, config('code.error'));
        }

        // 判断数据是否存在
        if ($data['id'] != $id) {
            return show(config('code.error'), '数据不存在', '', 404);
        }

        // 真删除
        if ($data['status'] == config('code.status_disable') && empty($data['rules'])) {
            try {
                $result = model('CompanyUser')->destroy($id);
            } catch (\Exception $e) {
                return show(config('code.error'), '网络忙，请重试', '', 500);
            }
            if (!$result) {
                return show(config('code.error'), '删除失败', '', 403);
            } else {
                return show(config('code.success'), '删除成功');
            }
        } else {
            return show(config('code.error'), '删除失败：供应商用户已启用或存在下级用户', '', 403);
        }
    }
}

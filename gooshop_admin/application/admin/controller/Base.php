<?php

namespace app\admin\controller;

use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use think\auth\Auth;
use think\Controller;
use think\Db;
use think\Request;

/**
 * admin模块登录授权基础控制器类
 * Class Base
 * @package app\admin\controller
 */
class Base extends Common
{
    /**
     * 模块
     * @var string
     */
    public $module = 'admin';

    /**
     * 登录账户的基本信息
     * @var array
     */
    public $companyUser = [];

    /**
     * 初始化方法
     */
    public function _initialize()
    {
        parent::_initialize();

        // 初始化参数
        $this->module = request()->module(); // 模块

        // 判断是否登录
        if (!($this->isLogin())) {
            return show(config('code.error'), '未登录', '', 401);
        }

        // Auth权限认证：对节点进行认证
        $this->checkAuth();
    }

    /**
     * 判断是否登录
     * @return bool
     */
    public function isLogin()
    {
        // 判断 token 是否存在
        if (empty($this->headers['company-user-token'])) {
            return false;
        }

        // 判断 token 合法性
        $aes = new Aes();
        $companyToken = $aes->decrypt($this->headers['company-user-token']); // AES解密
        if (empty($companyToken)) {
            return false;
        }

        // 查询账户是否存在或启用
        $companyUser = model('CompanyUser')->loginstatus($companyToken);
        if(!$companyUser || $companyUser['status'] != config('code.status_enable')){
            return false;
        }

        // 验证 token 过期时间
        $time = time();
        if($time - $companyUser['token_time'] > 3600*24){
            return false;
        }

        // 验证通过，重置过期时间
        model('CompanyUser')->setlogintime($companyToken);
        // 赋值登录账户的基本信息
        $this->companyUser = $companyUser;
        return true;
    }

    /**
     * Auth权限认证：对节点进行认证
     */
    public function checkAuth()
    {
        $auth = new Auth(); // 实例化Auth权限认证类
        $controller = request()->controller(); // 控制器
        $action = request()->action(); // 方法
        $name = $this->module . '/' . $controller . '/' . $action; // 规则唯一标识（节点）
        $name = request()->url(); // 规则唯一标识（请求URL）
        $notCheckName = [ // 不需认证的规则
            $this->module . '/' .'Index/index',
            $this->module . '/' .'Login/logout',
        ];
        // 超级管理员拥有所有权限
        if (!in_array($this->companyUser->user_id, $this->getSuperAdmin())) {
            // 不需认证的规则
            if (!in_array($name, $notCheckName)) {
                // 检查权限
                if (!$auth->check($name, $this->companyUser->user_id, $type = 1)) {
                    throw new ApiException('无权访问' . $name, 401);
                    //return show(config('code.error'), '无权访问', '', 401); //$this->error('无权访问');
                }
            }
        }
    }

    /**
     * 获取超级管理员
     * @return array
     */
    public function getSuperAdmin()
    {
        $userGroupIds = Db::name('auth_group_access')->where('group_id = 1')->select();
        $superAdmin = [];
        foreach ($userGroupIds as $key => $value) {
            $superAdmin[] = $value['uid'];
        }
        return $superAdmin;
    }
}

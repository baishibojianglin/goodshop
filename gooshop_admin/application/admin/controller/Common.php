<?php

namespace app\admin\controller;

use think\Cache;
use think\Controller;
require_once ROOT_PATH . 'vendor/oss/autoload.php';

/**
 * admin模块公共控制器类
 * Class Common
 * @package app\admin\controller
 */
class Common extends Controller
{
    /**
     * headers信息
     * @var string
     */
    public $headers = '';

    /**
     * page 当前页
     * @var string
     */
    public $page = '';

    /**
     * size 每页条数
     * @var string
     */
    public $size = '';

    /**
     * 每页从第几条开始
     * @var int
     */
    public $from = 0;

    /**
     * 初始化
     */
    public function _initialize()
    {
        //$this->checkRequestAuth(); // TODO：生产环境必须检查数据的合法性
    }

    /**
     * 获取分页page、size、from
     * @param $params
     */
    public function getPageAndSize($params)
    {
        $this->page = !empty($params['page']) ? $params['page'] : 1;
        $this->size = !empty($params['size']) ? $params['size'] : config('paginate.list_rows');
        $this->from = ($this->page - 1) * $this->size; // 'limit from,size'
    }


    /**
     * 上传图片
     */
    public function test(){
        $file = request()->file('zhizhao');
    }





}

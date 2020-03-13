<?php
use think\Route;

/*-----后台管理中心路由-----*/
//登录
Route::POST('login','admin/Login/login');
//登录验证码
Route::GET('code','admin/Login/createverifycode');
//上传图片
Route::POST('upload','admin/Common/uploadimg');
//删除图片
Route::POST('deleteimages','admin/Common/deleteimg');
//获取平台销售区域数据
Route::POST('platformarea','admin/Company/getarea_platform');
//获取供应商销售区域数据
Route::POST('companyarea','admin/Company/getarea_company');
//插入供应商销售区域数据
Route::POST('companyareainsert','admin/Company/area_insert');
//获取供应商销售商品种类
Route::POST('getshopcate','admin/Company/getshopcate_company');
//插入供应商销售商品种类
Route::POST('shopcateinsert','admin/Company/cate_insert');
// 区域
Route::resource('region', 'admin/Region');
// 商品类别
Route::resource('goods_cate', 'admin/GoodsCate');
Route::get('goods_cate_tree', 'admin/GoodsCate/goodsCateTree'); // 商品类别列表树
// 商品品牌
Route::resource('goods_brand', 'admin/GoodsBrand');
// Auth用户组
Route::resource('auth_group', 'admin/AuthGroup');
Route::get('auth_group_tree', 'admin/AuthGroup/authGroupTree'); // Auth用户组列表树
Route::put('config_auth_group_rule/:id', 'admin/AuthGroup/configAuthGroupRule'); // 配置Auth用户组权限规则
// Auth权限规则
Route::resource('auth_rule', 'admin/AuthRule');
Route::get('auth_rule_tree', 'admin/AuthRule/authRuleTree'); // Auth权限规则列表树
Route::get('lazy_load_auth_rule_tree', 'admin/AuthRule/lazyLoadAuthGroupTree'); // 懒加载Auth权限规则树形列表
// Auth权限规则菜单
Route::get('auth_rule_menus', 'admin/AuthRuleMenus/authRuleMenus'); // 权限规则菜单
// 供应商账户
Route::resource('company_user', 'admin/CompanyUser');
// 供应商
Route::get('company_tree', 'admin/Company/companyTree'); // 供应商列表树
Route::POST('createCompany','admin/Company/submitCompany'); // 创建供应商

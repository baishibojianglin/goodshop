import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '@/views/Login.vue'
import Home from '@/views/Home.vue'
// 供应商管理
import Companycreate from '@/pages/company/Companycreate.vue'
import Companyarea from '@/pages/company/Companyarea.vue'
import Companycate from '@/pages/company/Companycate.vue'
// 区域管理
import Region from '@/pages/region/Region.vue'
import RegionCity from '@/pages/region/RegionCity.vue'
import RegionCounty from '@/pages/region/RegionCounty.vue'
import RegionTown from '@/pages/region/RegionTown.vue'
// 商品管理·商品类别
import GoodsCate from '@/pages/goods_cate/GoodsCate.vue'
import GoodsCateAdd from '@/pages/goods_cate/GoodsCateAdd.vue'
import GoodsCateEdit from '@/pages/goods_cate/GoodsCateEdit.vue'
// 商品管理·商品品牌
import GoodsBrand from '@/pages/goods_brand/GoodsBrand.vue'
import GoodsBrandAdd from '@/pages/goods_brand/GoodsBrandAdd.vue'
import GoodsBrandEdit from '@/pages/goods_brand/GoodsBrandEdit.vue'
// 账户管理·角色管理
import AuthGroup from '@/pages/auth_group/AuthGroup.vue'
import AuthGroupAdd from '@/pages/auth_group/AuthGroupAdd.vue'
import AuthGroupEdit from '@/pages/auth_group/AuthGroupEdit.vue'
import AuthGroupRule from '@/pages/auth_group/AuthGroupRule.vue'
// 账户管理·权限规则
import AuthRule from '@/pages/auth_rule/AuthRule.vue'
import AuthRuleAdd from '@/pages/auth_rule/AuthRuleAdd.vue'
import AuthRuleEdit from '@/pages/auth_rule/AuthRuleEdit.vue'
// 账户管理·供应商账户
import CompanyUser from '@/pages/company_user/CompanyUser.vue'
import CompanyUserAdd from '@/pages/company_user/CompanyUserAdd.vue'
import CompanyUserEdit from '@/pages/company_user/CompanyUserEdit.vue'

Vue.use(VueRouter)

const routes = [
	{
		// 1--登录
		path: '/',
		name: 'login',
		component:Login
		//component:() => import(/* webpackChunkName: '1' */ '../views/Login.vue')
	},
	{
		// 1--首页
		path: '/home',
		name: 'home',
		component:Home,
		children: [
			// 2--供应商管理
			{path: 'companycreate',name: 'companycreate',component:Companycreate}, //创建供应商
			{path: 'companyarea',name: 'companyarea',component:Companyarea}, //供应商配置销售地区信息
			{path: 'companycate',name: 'companycate',component:Companycate}, //供应商配置商品种类信息
			
			// 2--区域管理
			{path: 'region', name: 'region', component: Region}, // 省级区域
			{path: 'regioncity', name: 'regioncity', component: RegionCity}, // 市级区域
			{path: 'regioncounty', name: 'regioncounty', component: RegionCounty}, // 区县级区域
			{path: 'regiontown', name: 'regiontown', component: RegionTown}, // 乡镇街道级区域
			// 2--商品管理
			// 商品类别
			{path: 'goodscate', name: 'goodscate', component: GoodsCate}, // 商品类别
			{path: 'goodscateadd', name: 'goodscateadd', component: GoodsCateAdd}, // 新增商品类别
			{path: 'goodscateedit', name: 'goodscateedit', component: GoodsCateEdit}, // 编辑商品类别
			// 商品品牌
			{path: 'goodsbrand', name: 'goodsbrand', component: GoodsBrand}, // 商品品牌
			{path: 'goodsbrandadd', name: 'goodsbrandadd', component: GoodsBrandAdd}, // 新增商品品牌
			{path: 'goodsbrandedit', name: 'goodsbrandedit', component: GoodsBrandEdit}, // 编辑商品品牌
			// 2--账户管理
			// 角色管理
			{path: 'auth_group', name: 'auth_group', component: AuthGroup}, // 角色管理
			{path: 'auth_group_add', name: 'auth_group_add', component: AuthGroupAdd}, // 新增角色
			{path: 'auth_group_edit', name: 'auth_group_edit', component: AuthGroupEdit}, // 编辑角色
			{path: 'auth_group_rule', name: 'auth_group_rule', component: AuthGroupRule}, // 角色权限规则配置
			// 权限规则
			{path: 'auth_rule', name: 'auth_rule', component: AuthRule}, // 权限规则
			{path: 'auth_rule_add', name: 'auth_rule_add', component: AuthRuleAdd}, // 新增权限规则
			{path: 'auth_rule_edit', name: 'auth_rule_edit', component: AuthRuleEdit}, // 编辑权限规则
			// 供应商账户
			{path: 'company_user', name: 'company_user', component: CompanyUser}, // 供应商账户
			{path: 'company_user_add', name: 'company_user_add', component: CompanyUserAdd}, // 新增供应商账户
			{path: 'company_user_edit', name: 'company_user_edit', component: CompanyUserEdit}, // 编辑供应商账户
		]
	}
]

const router = new VueRouter({
	routes
})

export default router

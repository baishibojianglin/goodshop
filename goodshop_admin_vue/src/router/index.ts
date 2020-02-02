import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '@/views/Login.vue'
import Home from '@/views/Home.vue'
import Companycreate from '@/pages/company/Companycreate.vue'
import Region from '@/pages/region/Region.vue'
import RegionCity from '@/pages/region/RegionCity.vue'
import RegionCounty from '@/pages/region/RegionCounty.vue'
import RegionTown from '@/pages/region/RegionTown.vue'
import GoodsCate from '@/pages/goods_cate/GoodsCate.vue'
import GoodsCateAdd from '@/pages/goods_cate/GoodsCateAdd.vue'
import GoodsCateEdit from '@/pages/goods_cate/GoodsCateEdit.vue'
import GoodsBrand from '@/pages/goods_brand/GoodsBrand.vue'
import GoodsBrandAdd from '@/pages/goods_brand/GoodsBrandAdd.vue'
import GoodsBrandEdit from '@/pages/goods_brand/GoodsBrandEdit.vue'

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
			{
				// 创建供应商
				path: 'companycreate',
				name: 'companycreate',
				component:Companycreate
			},
			// 2--区域管理
			{path: 'region', name: 'region', component: Region}, // 省级区域
			{path: 'regioncity', name: 'regioncity', component: RegionCity}, // 市级区域
			{path: 'regioncounty', name: 'regioncounty', component: RegionCounty}, // 区县级区域
			{path: 'regiontown', name: 'regiontown', component: RegionTown}, // 乡镇街道级区域
			// 3--商品管理
			{path: 'goodscate', name: 'goodscate', component: GoodsCate}, // 商品类别
			{path: 'goodscateadd', name: 'goodscateadd', component: GoodsCateAdd}, // 新增商品类别
			{path: 'goodscateedit', name: 'goodscateedit', component: GoodsCateEdit}, // 编辑商品类别
			{path: 'goodsbrand', name: 'goodsbrand', component: GoodsBrand}, // 商品品牌
			{path: 'goodsbrandadd', name: 'goodsbrandadd', component: GoodsBrandAdd}, // 新增商品品牌
			{path: 'goodsbrandedit', name: 'goodsbrandedit', component: GoodsBrandEdit}, // 编辑商品品牌
		]
	}
]

const router = new VueRouter({
	routes
})

export default router

import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '@/views/Login.vue'
import Home from '@/views/Home.vue'
import Companycreate from '@/pages/company/Companycreate.vue'
import Region from '@/pages/region/Region.vue'
import RegionCity from '@/pages/region/RegionCity.vue'
import RegionCounty from '@/pages/region/RegionCounty.vue'
import RegionTown from '@/pages/region/RegionTown.vue'


Vue.use(VueRouter)

const routes = [
  {
	//1--登录
    path: '/',
    name: 'login',
	component:Login
	//component:() => import(/* webpackChunkName: '1' */ '../views/Login.vue')	
  },
  {
	//1--首页
    path: '/home',
    name: 'home',
	component:Home,
	children: [
		//2--供应商管理
		{
			//创建供应商
			path: 'companycreate',
			name: 'companycreate',
			component:Companycreate
		},
		// 2--区域管理
		{path: 'region', name: 'region', component: Region}, // 省级区域
		{path: 'regioncity', name: 'regioncity', component: RegionCity}, // 市级区域
		{path: 'regioncounty', name: 'regioncounty', component: RegionCounty}, // 区县级区域
		{path: 'regiontown', name: 'regiontown', component: RegionTown}, // 乡镇街道级区域
	]
  }

]

const router = new VueRouter({
		routes
})




export default router

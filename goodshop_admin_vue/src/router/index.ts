import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '@/views/Login.vue'
import Home from '@/views/Home.vue'
import Companycreate from '@/pages/company/Companycreate.vue'
import Region from '@/pages/region/Region.vue'


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
		 //2--地区管理
		 {
		   //地区管理
		   path: 'region',
		   name: 'region',
		   component:Region
		 }
	]
  }

]

const router = new VueRouter({
		routes
})




export default router

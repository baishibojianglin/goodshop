import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '@/views/Login.vue'
import Home from '@/views/Home.vue'

Vue.use(VueRouter)

const routes = [
  {
	//登录
    path: '/',
    name: 'login',
	component:Login
	//component:() => import(/* webpackChunkName: '1' */ '../views/Login.vue')	
  },
  {
	//首页
    path: '/home',
    name: 'home',
	component:Home,
	children: [
		 //供应商管理
		 {
		   //创建供应商
		   path: '/companycreate',
		   name: 'companycreate',
		   component:() => import('../pages/company/Create')	
		 }		
	]
  }

]

const router = new VueRouter({
		routes
})




export default router

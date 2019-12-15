import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '../views/Login.vue'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'login',
    component: Login
  },
  {
    path: '/home',
    name: 'home',
    //component: () => import('../views/Home.vue')
	component: Home
  }
]

const router = new VueRouter({
  routes
})

//router报错解决方案
router.onError((error) => {
    const pattern = /Loading chunk (\d)+ failed/g;
    const isChunkLoadFailed = error.message.match(pattern);
    if(isChunkLoadFailed){ 
		 //避免死循环的加载
         location.reload();
    }   
});

export default router

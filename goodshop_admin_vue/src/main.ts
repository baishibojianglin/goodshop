import Vue from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import axios from 'axios'

//公用配置
Vue.config.productionTip = false
Vue.prototype.$axios = axios

//引入基本样式
import './assets/css/basic.css'

//引入element-ui
import 'element-ui/lib/theme-chalk/index.css';
import { Container,Header,Aside,Main,Footer,Button,Input} from 'element-ui';

Vue.use(Container);
Vue.use(Header);
Vue.use(Aside);
Vue.use(Main);
Vue.use(Footer);
Vue.use(Button);
Vue.use(Input);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

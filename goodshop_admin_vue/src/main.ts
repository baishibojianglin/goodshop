import Vue from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import axios from 'axios'

//公用配置
Vue.config.productionTip = false
Vue.prototype.$axios = axios  //ajax插件
Vue.prototype.$url='http://www.goodshop.com/index.php/'  //后台域名
axios.defaults.withCredentials=true   //解决跨域后保持相同session(允许ajax携带cook)


//引入基本样式
import './assets/css/basic.css'

//验证签名值
Vue.prototype.$sign = 'jl_goodshop';

//引入element-ui
import 'element-ui/lib/theme-chalk/index.css';
import 'element-ui/lib/theme-chalk/base.css';
import { Row,Col,Button,Input,Message,Form,FormItem} from 'element-ui';
import CollapseTransition from 'element-ui/lib/transitions/collapse-transition';



Vue.use(Button);
Vue.use(Input);
Vue.use(Button);
Vue.use(Row);
Vue.use(Col);
Vue.use(Form);
Vue.use(FormItem);
Vue.component(CollapseTransition.name, CollapseTransition);






Vue.prototype.$message = Message

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

<template>
  <div class="home">
	<el-row>
		
	  <el-col :span="24" class="homeheader color-white"> <!--header s-->    
		   <el-col :span="5">
			   <div class="hometitle">{{name}}</div>
		   </el-col>	  
	  </el-col> <!--header e-->

	  <el-col :span="24"> <!--content s-->    
		   <el-col  :xs="6" :sm="5" :md="4" :lg="3" :xl="2">  <!--menu s-->
			   <div class="homemenu">
				   <dl class="m0">
					   <dt @click="menush(0)">
						   <span class="el-icon-menu" id="menu0"> 供应商管理</span> 
						   <span class="fr derection" :class="menuvalue[0]?derectionup:derectiondown"></span>
					   </dt>
					   <el-collapse-transition>
						   <div v-show="menuvalue[0]">
							   <router-link to="/home/companycreate"><dd id='menu01' :class="activevalue[0]?activeclass:''"  @click="menuactive(0,0,1)">新建供应商</dd></router-link>
							   <router-link to="/home/companycreate"><dd id='menu02' :class="activevalue[1]?activeclass:''"  @click="menuactive(1,0,2)">供应商管理</dd></router-link>
						   </div>
					   </el-collapse-transition>				  
					   <dt @click="menush(1)">
						   <span class="el-icon-menu"> 供应商管理</span> 
						   <span class="fr derection" :class="menuvalue[1]?derectionup:derectiondown"></span>
					   </dt>
					   <dd v-show="menuvalue[1]">新建供应商</dd>
					   <dd v-show="menuvalue[1]">供应商管理</dd>
				   </dl>
			   </div>
		   </el-col> <!--menu e-->	
		   <el-col  :xs="18" :sm="19" :md="20" :lg="21" :xl="22">  <!--main s-->
		   
		       <el-col  :span='24' class="createtitle">
				   <span>{{menuonetitle}} > {{menutwotitle}}</span>	
			   </el-col>
			   
		       <div class="homemain">
                   <router-view></router-view>				   
			   </div>
		   </el-col> <!--main e-->			 
			 
			 
	  </el-col> <!--content e-->
	  
	</el-row>									
  </div>
</template>

<script>
    import { mapState } from 'vuex';
	import { mapMutations } from 'vuex';
	
	export default {
	  name: 'home',
	  data(){
		return {
			name:'', //供应商名字
			menuvalue:[false,false], //菜单层级
			derectiondown:'el-icon-arrow-down', //一级菜单向上箭头
			derectionup:'el-icon-arrow-up', //一级菜单向下箭头
			activevalue:[false],//激活菜单
			activeclass:'activecolor' //选中二级菜单样式
			
		}  
	  },
	  components: {
	 
	  },
	  computed: {
	    ...mapState([
          'menuonetitle',
		  'menutwotitle'
	    ])
	  },
	  mounted(){
		//获取公司（供应商）基本信息
		let account=JSON.parse(localStorage.getItem("company"));
		this.name=account['name'];
		this.logincheck(account.id);
	  },
	  methods: {
		//vuex存储共享数据
		...mapMutations([
		    'menutitle', //存储菜单标题
		  ]),	
		//检测登录
		logincheck(id,time){
				//数据提交
				this.$axios.post(this.$url+'islogin',{
					id:'',
					sign:''
				}).then(function(res){
				    
				})			
		},
		//menu折叠效果
		menush(val){
			//控制一级菜单折叠
			let self=this;
			this.menuvalue.forEach((value,index)=>{
				if(index!=val){
				 self.$set(this.menuvalue,index,false);				
				}
			});
			this.$set(this.menuvalue,val,!this.menuvalue[val]);
			//所有一级菜单折叠后，将二级菜单状态初始化到最初状态
			if(!this.menuvalue[val]){
				this.activevalue.forEach((value,index)=>{
				 self.$set(this.activevalue,index,false);				
				});			
			}
		},
		//menu折叠效果
		//val:选中激活状态样式索引数组
		//onetitle:一级标题
		//twotitle:二级标题
		menuactive(val,onetitle,twotitle){
			//控制选中menu样式
			let self=this;
			this.activevalue.forEach((value,index)=>{
				if(index!=val){
				 self.$set(this.activevalue,index,false);				
				}
			});
			this.$set(this.activevalue,val,true);
			//设置标题
			let titleobject=new Object();
            titleobject.onetitletext=document.getElementById('menu'+onetitle).innerText;
			titleobject.twotitletext=document.getElementById('menu'+onetitle+''+twotitle).innerText;		
			this.menutitle(titleobject);
		}
		
	

		
		
	  }

	}
</script>
<style>	
 .homeheader{
	 background-color:#003366;
 }
 .hometitle{
	 line-height: 50px;
	 text-indent: 10px;
 }
 .homemenu{
	 padding: 10px 10px;
	 border-right: 1px solid #E3E0D5;
	 background-color: #EEEEEE;
 }
 .derection{
	padding: 10px 5px; 
 }
 dt,dd{
	 line-height: 35px;
	 border-bottom: 1px solid #E3E0D5;
	 cursor: pointer;
 }
 a:hover{
	 color:#1D72B9;
 }
 a {
   text-decoration: none;
   color:#000;
 }
 .router-link-active {
   text-decoration: none;
 }
 .activecolor a{
	 color:#1D72B9;
 }
 .createtitle{
    border-bottom: 1px solid #E8EAED;
 	line-height: 40px;
 	background-color: #FBFCFC;
 	padding: 0 10px;
 	font-size: 0.8em;
 }
</style>

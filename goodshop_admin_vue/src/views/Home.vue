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
						   <span class="el-icon-menu"> 供应商管理</span> 
						   <span class="fr derection" :class="menuvalue[0]?derectionup:derectiondown"></span>
					   </dt>
					   <el-collapse-transition>
						   <div v-show="menuvalue[0]">
							   <dd><router-link to="/home/companycreate">新建供应商</router-link></dd>
							   <dd>供应商管理</dd>
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
                   <router-view></router-view>
		   </el-col> <!--main e-->			 
			 
			 
	  </el-col> <!--content e-->
	  
	</el-row>									
  </div>
</template>

<script>


export default {
  name: 'home',
  data(){
	return {
		name:'', //机构名字
		menuvalue:[false,false], //菜单层级
		derectiondown:'el-icon-arrow-down',
		derectionup:'el-icon-arrow-up'
		
		
	}  
  },
  components: {
 
  },
  mounted(){
    //获取公司（供应商）基本信息
    let account=JSON.parse(localStorage.getItem("company"));
    this.name=account['name'];
  },
  methods: {
	//menu折叠效果
	menush(val){
		let self=this;
		this.menuvalue.forEach((value,index)=>{
			if(index!=val){
			 self.$set(this.menuvalue,index,false);				
			}
		});
		this.$set(this.menuvalue,val,!this.menuvalue[val]);
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
</style>

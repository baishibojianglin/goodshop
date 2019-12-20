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
					   <dt><span class="el-icon-s-data"></span> 供应商管理</dt>
					   <dd>分公司管理</dd>
					   <dd>供应商管理</dd>
				   </dl>
			   </div>
		   </el-col> <!--menu e-->	  
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
 dt,dd{
	 line-height: 35px;
	 border-bottom: 1px solid #E3E0D5;
 }
</style>

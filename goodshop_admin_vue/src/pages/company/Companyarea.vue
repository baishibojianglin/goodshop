<template>
	<div class="area">
		<el-row>
		  <el-col :span="15">
			 <el-steps :active="active" finish-status="success" style="margin-left: 50px;margin-bottom: 50px;">
			   <el-step title="填写基本信息"></el-step>
			   <el-step title="配置销售地区"></el-step>
			   <el-step title="创建成功"></el-step>
			 </el-steps>			  
		  </el-col>
		 </el-row>


         <el-tree :data="area" @node-click="handleNodeClick" show-checkbox></el-tree>
		
	
	</div>
</template>

 <script>
   export default {
     data() {
		   return {
			   active: 1,  //步骤条
			   area: []
		    }
     },
	 mounted(){
		//调用获取数据方法
	    this.getarea();
	 },

     methods: {

		  /**
		   * 步骤条
		   */
		  next(){
			if (this.active++ > 2) this.active = 0;
		  },
		  /**
		   * 获取区域数据
		   */
		  getarea(){
			//向后台请求地区数据
			let self=this;
			let company=JSON.parse(localStorage.getItem('company')); //取出的缓存的登录账户信息
			this.$axios.post(this.$url+'companyarea',{
				 companyid:company.company_id  //获取登录账号所属的供应商id
			}).then(function(res){
				console.log(res.data.data)
				//向省级区域赋值
				res.data.data.forEach((value,index)=>{
					self.$set(self.area,index,{index:index,label:value.region_name,region_id:value.region_id,level:value.level,parent_id:value.parent_id});
				})						
			})			  
		  },
		  
		  handleNodeClick(data) {
		          console.log(data);
		  },

		  
     }
   }
 </script>  

<style>
	.area{
		padding:20px 0 50px 0;
	}
</style>

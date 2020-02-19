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
		 
	 
		<el-tree
		  :props="props"
		  :load="loadNode"
		  empty-text=''
		  lazy
		  show-checkbox>
		</el-tree> 

		
	
	</div>
</template>

 <script>
   export default {
     data() {
		   return {
			    active: 1,  //步骤条
			    companyid:'', //登录账号所属供应商
				parent_id:'',
				level:'',
				props: {
				  label: 'region_name',
				  //children: 'region_name',
				  //isLeaf: true
				},


		    }
     },
	 mounted(){
		 let self=this;
		 let company=JSON.parse(localStorage.getItem('company')); //取出的缓存的登录账户信息
		 this.companyid=company.company_id; //获取登录账号所属的供应商id
		 	     
	 },

     methods: {

		  /**
		   * 步骤条
		   */
		  next(){
			if (this.active++ > 2) this.active = 0;
		  },

		  loadNode(node, resolve) {	
			let self=this;
			let company=JSON.parse(localStorage.getItem('company')); //取出的缓存的登录账户信息
			this.companyid=company.company_id; //获取登录账号所属的供应商id
			if(node.data){
				this.parent_id=node.data.region_id;
				this.level=node.data.level+1;
			}else{
				this.parent_id=0;
				this.level=1;
			}
			console.log(node.data)
			//平台账号
			if(this.companyid==1){ 
				this.$axios.post(this.$url+'platformarea',{
					 parent_id:this.parent_id,
					 level:this.level
				}).then(function(res){
					    //console.log(res.data)
						if (node.level === 0) {
						  return resolve(res.data.data);
						}
						if (node.level > 1) return resolve(res.data.data);

						setTimeout(() => {
						  const data = res.data.data;		
						  resolve(data);
						}, 500);				
									
				})
				
				
			}			  
			  
			  

			
			
		  }

		  
     }
   }
 </script>  

<style>
	.area{
		padding:20px 0 50px 0;
	}

</style>

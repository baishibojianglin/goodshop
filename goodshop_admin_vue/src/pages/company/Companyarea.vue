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
		  lazy
		  show-checkbox>
		</el-tree>
		
	
	</div>
</template>

 <script>
   export default {
     data() {
		   return {
			   props: {
				 label: 'name',
				 children: 'zones',
				 isLeaf: 'leaf'
			   },
			   onedata:[
				   {name:123},
				   {name:345}
			   ],
			   active: 1,  //步骤条
		   }
     },
	 mounted(){
		let self=this;
		let company=JSON.parse(localStorage.getItem('company')); //取出的缓存的登录账户信息
        this.$axios.post(this.$url+'createCompany',{
           companyid:company.company_id  //获取登录账号所属的供应商id
        }).then(function(res){

        })    
		 
	 },
     methods: {

		  /**
		   * 步骤条
		   */
		  next(){
			if (this.active++ > 2) this.active = 0;
		  },
		  
		  loadNode(node, resolve) {
			if (node.level === 0) {
			  return resolve(this.onedata);
			}
			if (node.level > 1) return resolve([]);

			setTimeout(() => {
			  const data = [{
				name: 'leaf',
				leaf: true
			  }, {
				name: 'zone'
			  }];

			  resolve(data);
			}, 500);	
		   }
		  
		  

     }
   }
 </script>  

<style>
	.area{
		padding:20px 0 50px 0;
	}
</style>

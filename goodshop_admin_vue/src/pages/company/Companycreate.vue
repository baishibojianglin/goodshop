<template>
	<div class="create">
		 <el-form  ref="ruleForm" :model="ruleForm" :rules="rules"  label-width="100px">
			 
		   <el-form-item label="供应商名称" prop="name">
			 <el-input style="width:350px;"  v-model="ruleForm.name"></el-input>
		   </el-form-item>

		   <el-form-item label="供应商地址" prop="address">
			 <el-input style="width:350px;"  v-model="ruleForm.address"></el-input>
		   </el-form-item>

		   <el-form-item label="供应商电话" prop="phone">
			 <el-input style="width:350px;"  v-model="ruleForm.phone"></el-input>
		   </el-form-item>

		   
		   <el-form-item>
			 <el-button type="primary" @click="submitForm('ruleForm')">立即创建</el-button>
			 <el-button @click="resetForm('ruleForm')">重置</el-button>
		   </el-form-item>
		 </el-form>    
	</div>
</template>

 <script>
   export default {
     data() {
		   return {
				ruleForm: {
				   name: '',
				   address:'',
				   phone:''
				},
				rules: {
				  name: [
					{ required: true, message: '请输入供应商名称', trigger: 'blur' }
				  ],
				  address:[
					{ required: true, message: '请输入供应商地址', trigger: 'blur' }					  
				  ],
				  phone:[
					{ required: true, message: '请输入供应商电话', trigger: 'blur' }					  
				  ],				  
				}
		   }
     },
     methods: {
		  submitForm(formName) {
			this.$refs[formName].validate((valid) => {
			  if (valid) {
				alert('submit!');
			  } else {
				console.log('error submit!!');
				return false;
			  }
			});
		  },
		  resetForm(formName) {
			this.$refs[formName].resetFields();
		  }
     }
   }
 </script>  

<style>
	.create{
		padding: 50px 0 20px 0;
	}
</style>

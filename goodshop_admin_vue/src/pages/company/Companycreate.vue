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

		   <el-form-item label="营业执照" prop="license">
			   <el-input v-show='false' style="width:350px;"  v-model="ruleForm.license"></el-input>
			   <el-upload :action="this.$url+'upload'" :limit="1" name='image'>
				  <el-button size="small" type="primary">上传副本图片</el-button>
			   </el-upload>
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
				   phone:'',
				   license:'',
				   fileList: []
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
				  license:[
					{ required: true, message: '请上传营业执照'}					  
				  ],									
				}
		   }
     },
     methods: {
		 /**
		  * 提交表单
		  * @param {Object} formName
		  */
		  submitForm(formName) {
			this.$refs[formName].validate((valid) => {
			  if (valid) {
				alert('submit!');
				console.log(filelist);
			  }else {
				console.log(this.fileList);
				return false;
			  }
			});
		  },
		  /**
		   * 重置表单
		   * @param {Object} formName
		   */
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

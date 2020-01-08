<template>
	<div class="create">
		 <el-form  ref="form" :model="form"  label-width="100px">
		   <el-form-item label="供应商名称">
			 <el-input style="width:300px;"  v-model="form.name"></el-input>
		   </el-form-item>
		   <el-form-item>
			 <el-button type="primary" @click="onSubmit">立即创建</el-button>
			 <el-button>取消</el-button>
		   </el-form-item>
		 </el-form>    
	</div>
</template>

 <script>
   export default {
     data() {
       return {
         form: {
           name: ''
         }
       }
     },
     methods: {
       onSubmit() {
         console.log('submit!');
       }
     }
   }
 </script>  

<style>
	.create{
		padding: 50px 0 20px 0;
	}
</style>

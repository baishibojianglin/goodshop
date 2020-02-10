<template>
	<div class="company_user_add">
		<el-card class="main-card">
			<div slot="header" class="clearfix">
				<el-row :gutter="20" type="flex" justify="space-between">
					<el-col :span="6"><span>编辑供应商账户</span></el-col>
					<el-col :span="3">
						<el-button size="mini" icon="el-icon-back" title="返回" @click="back()">返回</el-button>
					</el-col>
				</el-row>
			</div>
			<div class="">
				<!-- Form 表单 s -->
				<el-form ref="ruleForm" :model="form" :rules="rules" label-width="100px" size="small" class="demo-form-inline">
					<el-form-item prop="user_name" label="供应商账户名称">
						<el-input v-model="form.user_name" placeholder="输入供应商账户名称" clearable style="width:350px;"></el-input>
					</el-form-item>
					<el-form-item prop="avatar" label="证件照(头像)">
						<el-input v-model="form.avatar" v-show="false" style="width:350px;"></el-input>
						<el-upload :action="this.$url+'upload'" name="avatar" :on-success="handleUploadSuccess" :limit="1">
						<el-button size="medium" type="primary" plain icon="el-icon-upload">上传证件照</el-button>
						</el-upload>
					</el-form-item>
					<el-form-item prop="account" label="供应商账户账号">
						<el-input v-model="form.account" placeholder="输入供应商账户账号" clearable style="width:350px;"></el-input>
					</el-form-item>
					<el-form-item prop="phone" label="电话号码">
						<el-input v-model="form.phone" placeholder="输入供应商账户电话号码" clearable style="width:350px;"></el-input>
					</el-form-item>
					<el-form-item prop="ratio" label="提成比例">
						<el-input v-model="form.ratio" placeholder="输入供应商账户提成比例" clearable style="width:350px;"></el-input>
					</el-form-item>
					<el-form-item prop="status" label="状态">
						<el-radio-group v-model="form.status">
							<el-radio :label="1">启用</el-radio>
							<el-radio :label="0">禁用</el-radio>
						</el-radio-group>
					</el-form-item>
					<el-form-item>
						<el-button type="primary" plain @click="submitForm('ruleForm')">提交</el-button>
						<el-button plain @click="resetForm('ruleForm')">重置</el-button>
					</el-form-item>
				</el-form>
				<!-- Form 表单 e -->
			</div>
		</el-card>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				form: {
					/* user_name: '', // 供应商账户名称
					avatar: '', // 供应商账户证件照
					account: '', // 供应商账户账号
					phone: '', // 电话号码
					ratio: '', // 提成比例
					status: '', // 状态 */
				},
				rules: { // 验证规则
					user_name: [
						{ required: true, message: '请输入供应商账户名称', trigger: 'blur' },
						{ min: 2, max: 20, message: '长度在 2 到 20 个字符', trigger: 'blur' }
					],
					account: [
						{ required: true, message: '请输入供应商账户账号', trigger: 'blur' },
						{ min: 2, max: 20, message: '长度在 2 到 20 个字符', trigger: 'blur' }
					],
					/* avatar: [
						{ required: true, message: '请上传供应商账户证件照', trigger: 'blur' }
					] */
				}
			}
		},
		created() {
			this.getParams();
			this.getCompanyUser(); // 获取指定的供应商账户信息
		},
		methods: {
			/**
			 * 获取路由带过来的参数
			 */
			getParams() {
				this.form.user_id = this.$route.query.user_id;
			},
			
			/**
			 * 获取指定的供应商账户信息
			 */
			getCompanyUser() {
				let self = this;
				this.$axios.get(this.$url + 'company_user/' + this.form.user_id, {
					headers: {
						'company-user-id': JSON.parse(localStorage.getItem('company')).user_id,
						'company-user-token': JSON.parse(localStorage.getItem('company')).token
					}
				})
				.then(function(res) {
					if (res.data.status == 1) {
						// 供应商账户信息
						self.form = res.data.data;
					} else {
						self.$message({
							message: '网络忙，请重试',
							type: 'warning'
						});
					}
				})
				.catch(function (error) {
					self.$message({
						message: error.response.data.message,
						type: 'warning'
					});
				});
			},
			
			/**
			 * 编辑供应商账户提交表单
			 * @param {Object} formName
			 */
			submitForm(formName) {
				let self = this;
				this.$refs[formName].validate((valid) => {
					if (valid) {
						this.$axios.put(this.$url + 'company_user/' + this.form.user_id, {
							// 参数
							user_name: this.form.user_name,
							avatar: this.form.avatar,
							account: this.form.account,
							phone: this.form.phone,
							ratio: this.form.ratio,
							status: this.form.status
						}, {
							// 请求头配置
							headers: {
								'company-user-id': JSON.parse(localStorage.getItem('company')).user_id,
								'company-user-token': JSON.parse(localStorage.getItem('company')).token
							}
						})
						.then(function(res) {
							let type = res.data.status == 1 ? 'success' : 'warning';
							self.$message({
								message: res.data.message,
								type: type
							});
							self.$router.go(-1); // 返回上一页
						})
						.catch(function (error) {
							self.$message({
								message: error.response.data.message,
								type: 'warning'
							});
						});
					} else {
						self.$message({
							message: 'error submit!!',
							type: 'warning',
						});
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
			},
			
			/**
			 * 返回上一页
			 */
			back(){
				this.$router.go(-1);
			},
			
			/**
			 * 文件上传成功时的钩子
			 * @param {Object} response
			 * @param {Object} file
			 * @param {Object} fileList
			 */
			handleUploadSuccess(response, file, fileList){
				console.log(file);
			}
		}
	}
</script>

<style>
</style>

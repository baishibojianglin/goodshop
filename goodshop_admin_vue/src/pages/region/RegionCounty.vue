<template>
	<div class="region">
		<el-card class="box-card">
			<div slot="header" class="clearfix">
				<el-row :gutter="20">
					<el-col :span="6"><span>{{paren_name}}</span></el-col>
					<el-col :span="6">
						<!-- 查询 s -->
						<el-form :inline="true" :model="formInline" class="demo-form-inline">
							<el-form-item label="">
								<el-input :placeholder="'查询' + title" v-model="formInline.region_name" clearable>
									<el-button slot="append" icon="el-icon-search" @click="getRegionList"></el-button>
								</el-input>
							</el-form-item>
						</el-form>
						<!-- 查询 e -->
					</el-col>
					<el-col :span="6">
						<!-- 新增 s -->
						<el-form :inline="true" :model="formAddRegion" :rules="rules" ref="ruleForm" class="demo-form-inline">
							<el-form-item label="" prop="region_name">
								<el-input :placeholder="'新增'+ title" v-model="formAddRegion.region_name" clearable>
									<el-button slot="append" icon="el-icon-plus" @click="addRegion('ruleForm')"></el-button>
								</el-input>
							</el-form-item>
						</el-form>
						<!-- 新增 e -->
					</el-col>
					<el-col :span="3" :offset="3">
						<el-button size="mini" icon="el-icon-back" title="返回" @click="back()"></el-button>
					</el-col>
				</el-row>
			</div>
			<div class="">
				<!-- 区域列表 s -->
				<el-row :gutter="10">
					<el-col :xs="12" :sm="8" :md="6" :lg="4" :xl="3" v-for="(item, index) in regionList" :key="index" style="margin-bottom: 1rem;">
						<el-card>
							<span>{{item.region_name}}</span>
							<div style="margin-top: 1rem;">
								<el-button type="primary" size="mini" plain icon="el-icon-edit" @click="toDetail(item.region_id, item.region_name)">管理</el-button>
								<el-popconfirm confirmButtonText='确定' cancelButtonText='取消' icon="el-icon-info" iconColor="red" title="确定删除该区域？" style="margin-left: 0.5rem;">
									<el-button type="danger" size="mini" plain icon="el-icon-delete" slot="reference" title="删除"><!-- 删除 --></el-button>
								</el-popconfirm>
							</div>
						</el-card>
					</el-col>
				</el-row>
				<!-- 区域列表 e -->
			</div>
		</el-card>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				title: '区县',
				paren_name: '',
				formInline: {
					region_name: '' // 区域名称
				},
				regionList: [], // 区域列表，如 [{region_id: 1, region_name: '北京市', level: 1, parent_id: 0}, {…}, …]
				formAddRegion: {
					region_name: '',
					level: 3, // 区域级别
					parent_id: '' // 上级ID
				},
				rules: { // 验证规则
					region_name: [
						{ required: true, message: '请输入区域名称', trigger: 'blur' }
					],
				}
			}
		},
		created() {
			this.getParams();
		},
		mounted() { // 实例被挂载后调用
			this.getRegionList(); // 获取区域列表
		},
		methods: {
			/**
			 * 取到路由带过来的参数
			 */
			getParams() {
				this.paren_name = this.$route.query.parent_name;
				this.formAddRegion.parent_id = this.$route.query.parent_id;
				// console.log("接受的parent_id的值：", this.$route.query);
			},
			
			/**
			 * 获取区域列表
			 */
			getRegionList() {
				let self = this;
				this.$axios.get(this.$url+'region', {
					params: {
						region_name: this.formInline.region_name,
						level: 3,
						parent_id: this.$route.query.parent_id
					}
				})
				.then(function(res) {
					if (res.data.status == 1) {
						self.regionList = res.data.data;
					} else {
						self.$message({
							message: '网络忙，请重试',
							type: 'warning'
						});
					}
				})
				.catch(function (error) {
					console.log(error.response);
					self.$message({
						message: error.response.data.message,
						type: 'warning'
					});
				});
			},
			
			/**
			 * 新增区域
			 */
			addRegion(formName) {
				let self = this;
				this.$refs[formName].validate((valid) => {
					if (valid) {
						this.$axios.post(this.$url+'region', {
							region_name: this.formAddRegion.region_name,
							level: this.formAddRegion.level,
							parent_id: this.formAddRegion.parent_id
						})
						.then(function(res) {
							let type = res.data.status == 1 ? 'success' : 'warning';
							self.$message({
								message: res.data.message,
								type: type
							});
						})
						.catch(function (error) {
							console.log(error.response);
							self.$message({
								message: error.response.data.message,
								type: 'warning'
							});
						});
					} else {
						console.log('error submit!!');
						return false;
					}
					// this.formAddRegion.region_name = ''; // 初始化区域名称
				});
			},
			
			/**
			 * 跳转区域管理
			 * @param {Object} parent_id
			 * @param {Object} parent_name
			 */
			toDetail(parent_id, parent_name) {
				this.$router.push({path: "regiontown", query: {parent_id: parent_id, parent_name: parent_name}});
			},
			
			/**
			 * 返回上一页
			 */
			back(){
				this.$router.go(-1);
			},
		}
	}
</script>

<style>
	.box-card{
		margin: 1rem;
	}
</style>

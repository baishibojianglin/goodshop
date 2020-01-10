<template>
	<div class="region">
		<el-card class="box-card">
			<div slot="header" class="clearfix">
				<!-- 查询 s -->
				<el-form :inline="true" :model="formInline" class="demo-form-inline">
					<el-form-item label="">
						<el-input placeholder="请输入省级区域" v-model="formInline.region_name" clearable>
							<el-button slot="append" icon="el-icon-search" @click="onSubmit"></el-button>
						</el-input>
					</el-form-item>
				</el-form>
				<!-- 查询 e -->
			</div>
			<div class="">
				<!-- 区域列表 s -->
				<el-row :gutter="12">
					<el-col :xs="12" :sm="8" :md="8" :lg="6" :xl="1" v-for="(item, index) in regionList" :key="index" style="margin-bottom: 1rem;">
						<el-card>
							<span>{{item.region_name}}</span>
							<div style="margin-top: 1rem;">
								<el-button type="primary" size="mini" plain icon="el-icon-edit">管理{{item.region_id}}</el-button>
								<el-popconfirm confirmButtonText='确定' cancelButtonText='取消' icon="el-icon-info" iconColor="red" title="确定删除该区域？" style="margin-left: 0.5rem;">
									<el-button type="danger" size="mini" plain icon="el-icon-delete" slot="reference">删除</el-button>
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
				formInline: {
					region_name: ''
				},
				regionList: [] // 区域列表，如 [{region_id: 1, region_name: '北京市', level: 1, parent_id: 0}, {…}, …]
			}
		},
		mounted() { // 实例被挂载后调用
			this.getRegionList(); // 获取区域列表
		},
		methods: {
			/**
			 * 获取区域列表
			 */
			getRegionList() {
				let self = this;
				this.$axios.get(this.$url+'region', {
					params: {
						region_name: this.formInline.region_name
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
					console.log(error);
				});
			},
			
			/**
			 * 提交查询
			 */
			onSubmit() {
				this.getRegionList();
			}
		}
	}
</script>

<style>
	.box-card{
		margin: 1rem;
	}
</style>

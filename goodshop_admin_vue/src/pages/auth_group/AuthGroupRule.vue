<template>
	<div class="auth_group_rule">
		<el-card class="main-card">
			<div slot="header" class="clearfix">
				<el-row :gutter="20" type="flex" justify="space-between">
					<el-col :span="6"><span>配置角色权限规则</span></el-col>
					<el-col :span="3">
						<el-button size="mini" icon="el-icon-back" title="返回" @click="back()">返回</el-button>
					</el-col>
				</el-row>
			</div>
			<div class="">
				<!-- Tree 树形控件（可选择层级） s -->
				<el-tree :data="data" :props="defaultProps" show-checkbox @node-click="handleNodeClick"></el-tree>
				<!-- Tree 树形控件 e -->
			</div>
		</el-card>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				data: [{
					label: '一级 1',
					children: [{
						label: '二级 1-1',
						children: [{
							label: '三级 1-1-1'
						}]
					}]
					}, {
						label: '一级 2',
						children: [{
						label: '二级 2-1',
						children: [{
							label: '三级 2-1-1'
						}]
					}, {
						label: '二级 2-2',
						children: [{
							label: '三级 2-2-1'
							}]
						}]
					}, {
						label: '一级 3',
						children: [{
						label: '二级 3-1',
						children: [{
							label: '三级 3-1-1'
						}]
						}, {
							label: '二级 3-2',
							children: [{
								label: '三级 3-2-1'
							}]
						}]
				}],
				defaultProps: {
					children: 'children',
					label: 'label'
				}
			};
		},
		methods: {
			handleNodeClick(data) {
				console.log(data);
			}
		}
	};
</script>

<style>
</style>

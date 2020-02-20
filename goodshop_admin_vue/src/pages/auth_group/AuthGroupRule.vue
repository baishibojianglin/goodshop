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
				<el-tree
					:props="props"
					:load="loadNode"
					lazy
					show-checkbox
					@check-change="handleCheckChange">
				</el-tree>
				<!-- Tree 树形控件 e -->
			</div>
		</el-card>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				props: {
					label: 'name',
					children: 'zones'
				},
				count: 1
			};
		},
		methods: {
			handleCheckChange(data, checked, indeterminate) {
				console.log(data, checked, indeterminate);
			},
			handleNodeClick(data) {
				console.log(data);
			},
			loadNode(node, resolve) {
				if (node.level === 0) {
					return resolve([{ name: 'region1' }, { name: 'region2' }]);
				}
				if (node.level > 3) return resolve([]);
	
				var hasChild;
				if (node.data.name === 'region1') {
					hasChild = true;
				} else if (node.data.name === 'region2') {
					hasChild = false;
				} else {
					hasChild = Math.random() > 0.5;
				}
	
				setTimeout(() => {
					var data;
					if (hasChild) {
						data = [{
							name: 'zone' + this.count++
						}, {
							name: 'zone' + this.count++
						}];
					} else {
						data = [];
					}
		
					resolve(data);
				}, 500);
			}
		}
	};
</script>

<style>
</style>

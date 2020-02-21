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
				<el-tree :props="props" :load="loadNode" empty-text='' lazy show-checkbox></el-tree>
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
					label: 'title',
					isLeaf: 'leaf' // 指定节点是否为叶子节点
				},

				parent_id: '', // 父级ID
				level: '', // 层级
			};
		},
		methods: {
			/**
			 * 懒加载（权限规则） Tree 树形数据
			 * @param {Object} node
			 * @param {Object} resolve
			 */
			loadNode(node, resolve) {
				let self = this;
				if (node.data) {
					this.parent_id = node.data.id;
					this.level = node.data.level + 1;
				} else {
					this.parent_id = 0;
					this.level = 1;
				}
				
				// 懒加载Auth权限规则树形列表
				this.$axios.get(this.$url + 'lazy_load_auth_rule_tree', {
					params: {
						parent_id: this.parent_id,
						level: this.level,
					},
					headers: {
						'company-user-id': JSON.parse(localStorage.getItem('company')).user_id,
						'company-user-token': JSON.parse(localStorage.getItem('company')).token
					}
				}).then(function(res) {
					if (res.data.status == 1) {
						const data = res.data.data;
						data.forEach((value, index) => {
							// 当不存在子级时，指定节点为叶子节点
							if (value.children_count == 0) {
								value.leaf = true;
							}
						})
						
						/* if (node.level === 0) {
							return resolve(res.data.data);
						}
						if (node.level > 1) return resolve([]); */
										
						setTimeout(() => {
							resolve(data);
						}, 500);
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
			}
		}
	};
</script>

<style>
</style>

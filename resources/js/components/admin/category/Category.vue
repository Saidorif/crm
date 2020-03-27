<template>
	<div class="category">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i data-v-956a9a24="" class="peIcon pe-7s-drawer"></i>
				    Category 
				</h4>
				<router-link class="btn btn-primary" to="/crm/category/add"><i class="fas fa-plus"></i> Add</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Название</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getCategoryList.data">
							<td scope="row">{{index + 1}}</td>
							<td>{{item.name}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/category/edit/${item.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteCategory(item.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getCategoryList" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
		  </div>
	  	</div>
	</div>
</template>
<script>
	import {mapActions, mapGetters} from 'vuex'
	export default{
		data(){
			return{
				
			}
		},
		computed:{
			...mapGetters('category',['getCategoryList'])
		},
		methods:{
			...mapActions('category',['actionCategoryList','actionDeleteCategory']),
			async getResults(page = 1){ 
				await this.actionCategoryList(page)
			},
			async deleteCategory(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					await this.actionDeleteCategory(id)
					await this.actionCategoryList(page)
					toast.fire({
				    	type: 'success',
						title: 'Категория удалено!',
				    })
				}
			}
		},
		async mounted(){
			await this.actionCategoryList()
		}
	}
</script>
<style scoped>

</style>
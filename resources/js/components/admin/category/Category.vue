<template>
	<div class="category">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="nav-icon fas fa-box"></i>
				    Category 
				</h4>
				<router-link class="btn btn-primary" to="/crm/category/add"><i class="fas fa-plus"></i> Add</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover">
				<thead>
					<tr>
						<th scope="col">№</th>
						<th scope="col">Название</th>
						<th scope="col">Действия</th>
					</tr>
				</thead>
				<tbody>
					<tr>
					<th scope="row">1</th>
					<td>sadasd</td>
					<td>
						<router-link tag="button" class="btn" to="/crm/category/edit/1">
							<i class="fas fa-edit editColor"></i>
						</router-link>
						<button class="btn" @click="deleteCategory(1)">
							<i class="fas fa-trash-alt trashColor"></i>
						</button>
					</td>
					</tr>
				</tbody>
				<!-- <pagination :limit="4" :data="getCategoryList" @pagination-change-page="getResults"></pagination> -->
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
			...mapActions('category',['actionCategoryList']),
			// async getResults(page = 1){ 
			// 	await this.getCategoryList(page)
			// },
			deleteCategory(id){
				console.log(id)
			}
		},
		async mounted(){
			await this.actionCategoryList()
			console.log(this.getCategoryList)
		}
	}
</script>
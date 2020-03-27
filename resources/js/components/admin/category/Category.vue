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
				<table class="table table-bordered text-center table-hover">
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
								<i class="pe_icon pe-7s-junk trashColor"></i>
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
	.table th, .table td {
		padding: .55rem;
		padding-top: 0.55rem;
		padding-right: 0.55rem;
		padding-bottom: 0.55rem;
		padding-left: 0.55rem;
		vertical-align: middle;
		border-top: 1px solid #e9ecef;
	}

	.btn_transparent{
		background:transparent;
		border: none;
		font-size: 24px;
		margin-right: 5px;
		margin-left: 5px;
		line-height: 0;
	}
	.title_user{
		color: #3f6ad8;
		font-weight: bold;
		display: flex;
		align-items: center;

	}
	.card-header{
		display: flex;
		justify-content: space-between;
		align-items: center;
	}
	.card-header .title_user .peIcon{
		font-size: 30px;
		margin-right: 10px;
	}
	.btn.btn-primary{
		color: #3f6ad8;
		background: transparent;
		border: 1px solid #3f6ad8;
		font-size: 16px;
		line-height: 18px;
	}
	.btn.btn-primary i{
		font-size: 12px;
	}
	.card-header::after{
		display: none;
	}
</style>
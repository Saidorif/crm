<template>
	<div class="category">
			<Loader v-if="loading" />
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-drawer"></i>
				     {{ $t('admin_menu.directions') }}
				</h4>
				<router-link class="btn btn-primary" to="/crm/category/add"><i class="fas fa-plus mr-2"></i>{{ $t('add_info') }}</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">{{ $t('nameinfo') }}</th>
							<th scope="col">{{ $t('count') }}</th>
							<th scope="col"> {{ $t('time') }}</th>
							<th scope="col">{{ $t('action') }}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getCategoryList.data">
							<td scope="row">{{index + 1}}</td>
							<td>{{item.name}}</td>
							<td>{{item.qty}}</td>
							<td>{{item.time}}</td>
							<td>
								<router-link 
									tag="button" 
									class="btn_transparent" 
									:to='`/crm/category/edit/${item.id}`'
									v-if="$can('edit', 'TestCategoryController')"
								>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button 
									class="btn_transparent" 
									@click="deleteCategory(item.id)" 
									v-if="$can('destroy', 'TestCategoryController')"
								>
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
	import Loader from '../../Loader'
	export default{
		components:{
			Loader
		},
		data(){
			return{
				loading: true
			}
		},
		computed:{
			...mapGetters('category',['getCategoryList'])
		},
		methods:{
			...mapActions('category',['actionCategoryPag','actionDeleteCategory']),
			async getResults(page = 1){ 
				await this.actionCategoryPag(page)
			},
			async deleteCategory(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					await this.actionDeleteCategory(id)
					await this.actionCategoryPag(page)
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Категория удалено!',
				    })
				}
			}
		},
		async mounted(){
			await this.actionCategoryPag()
			this.loading = false
		}
	}
</script>
<style scoped>

</style>
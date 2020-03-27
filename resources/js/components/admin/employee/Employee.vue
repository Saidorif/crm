<template>
	<div class="employee">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-users"></i>
				    Employee 
				</h4>
				<router-link class="btn btn-primary" to="/crm/employee/add"><i class="fas fa-plus"></i> Add</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Ф.И.О</th>
							<th scope="col">Рол</th>
							<th scope="col">Управления</th>
							<th scope="col">Email</th>
							<th scope="col">Phone</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td scope="row">1</td>
							<td>Name</td>
							<td>user</td>
							<td>category</td>
							<td>email@mail.ru</td>
							<td>+99899999999</td>
							<td>
								<!-- <router-link tag="button" class="btn_transparent" :to='`/crm/employee/edit/${item.id}`'> -->
								<router-link tag="button" class="btn_transparent" to='/crm/employee/edit/1'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteEmployee(1)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
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
		methods:{
			async getResults(page = 1){ 
				// await this.actionCategoryPag(page)
			},
			deleteEmployee(id){

			}
		}
	}
</script>
<style scoped>
	
</style>
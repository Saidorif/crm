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
							<th scope="col">Должность</th>
							<th scope="col">Рол</th>
							<th scope="col">Управления</th>
							<th scope="col">Email</th>
							<th scope="col">Phone</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getEmployees.data">
							<td scope="row">{{index+1}}</td>
							<td>{{item.name}}</td>
							<td>{{item.position.name}}</td>
							<td>{{item.role.name}}</td>
							<td>category</td>
							<td>{{item.email}}</td>
							<td>{{item.phone}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/employee/edit/${item.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteEmployee(item.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getEmployees" @pagination-change-page="getResults"></pagination>
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
		async mounted(){
			let page = 1;
			await this.actionEmployees()
		},
		computed:{
			...mapGetters('employee',['getEmployees']),
		},
		methods:{
			...mapActions('employee',['actionEmployees']),
			async getResults(page = 1){ 
				await this.actionEmployees(page)
			},
			deleteEmployee(id){

			}
		}
	}
</script>
<style scoped>
	
</style>
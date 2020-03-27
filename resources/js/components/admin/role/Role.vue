<template>
	<div class="role">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-id"></i>
				    Role 
				</h4>
				<router-link class="btn btn-primary" to="/crm/role/add"><i class="fas fa-plus"></i> Add</router-link>
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
						<tr>
							<td scope="row">1</td>
							<td>user</td>
							<td>
								<!-- <router-link tag="button" class="btn_transparent" :to='`/crm/role/edit/${item.id}`'> -->
								<router-link tag="button" class="btn_transparent" to='/crm/role/edit/1'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteRole(1)">
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
		mounted(){
			
		},
		computed:{
			...mapGetters('role',['getRoles','getMassage'])
		},
		methods:{
			...mapActions('role',['actionRoles','actionDeleteRole'])
		}
	}
</script>
<style scoped>
	
</style>
<template>
	<div class="action">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-box1"></i>
				    Action 
				</h4>
				<router-link class="btn btn-primary" to="/crm/action/add"><i class="fas fa-plus"></i> Add</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Название</th>
							<th scope="col">Controller</th>
							<th scope="col">Code</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(cont,index) in getActions.data">
							<td scope="row">{{index+1}}</td>
							<td>{{cont.name}}</td>
							<td>controller</td>
							<td>{{cont.code}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/action/edit/${cont.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
							<!-- 	<button class="btn_transparent" @click="deleteConts(cont.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button> -->
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getActions" @pagination-change-page="getResults"></pagination>
				</table>
			  </div>
		  </div>
	  	</div>
	</div>
</template>
<script>
	import {mapActions,mapGetters} from 'vuex'
	export default{
		data(){
			return{

			}
		},
		async mounted(){
			await this.actionActions()
		},
		computed:{
			...mapGetters('action',['getActions','getMassage'])
		},
		methods:{
			...mapActions('action',['actionActions']),
			async getResults(page = 1){ 
				await this.actionActions(page)
			},
		}
	}
</script>
<style scoped>
	
</style>

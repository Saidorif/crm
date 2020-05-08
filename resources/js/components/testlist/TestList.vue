<template>
	<div class="test_list">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-browser"></i>
				    Test List 
				</h4>
		  	</div>
		  	<div class="card-body">
			  	<div class="table-responsive">
					<table class="table table-bordered text-center table-hover table-striped">
						<thead>
							<tr>
								<th scope="col">№</th>
								<th scope="col">Ф.И.О</th>
								<th scope="col">Направления</th>
								<th scope="col">Статус</th>
								<th scope="col">Количество вопроса</th>
								<th scope="col">Балл</th>
								<th scope="col">Действия</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(item,index) in getTestList.data">
								<td scope="row">{{index+1}}</td>
								<td>{{item.fio}}</td>
								<!-- <td>{{item.category.name}}</td> -->
								<td>{{item.status}}</td>
								<td>{{item.limit}}</td>
								<td>
								<!-- 	<router-link tag="button" class="btn_transparent" :to='`/crm/question/edit/${item.id}`'>
										<i class="pe_icon pe-7s-edit editColor"></i>
									</router-link> -->
								</td>
							</tr>
						</tbody>
						<pagination :limit="4" :data="getTestList" @pagination-change-page="getResults"></pagination>
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
			...mapGetters('test',['getTestList'])
		},
		methods:{
			...mapActions('test',['actionTestList']),
			async getResults(page = 1){ 
				await this.actionTestList(page)
			},
		},
		async mounted(){
			let page = 1
			await this.actionTestList({page:page})
			console.log(this.getTestList)
		}
	}
</script>
<style scoped>
	
</style>
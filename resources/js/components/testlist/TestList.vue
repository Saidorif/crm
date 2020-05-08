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
								<th scope="col">Заголовок</th>
								<th scope="col">Количество вопроса</th>
								<th scope="col">Балл</th>
								<th scope="col">Действия</th>
							</tr>
						</thead>
						<tbody>
						<!-- 	<tr v-for="(item,index) in getTestList.data">
								<td scope="row">{{index+1}}</td>
								<td>{{item.title}}</td>
								<td>{{item.category.name}}</td>
								<td>
									<router-link tag="button" class="btn_transparent" :to='`/crm/question/edit/${item.id}`'>
										<i class="pe_icon pe-7s-edit editColor"></i>
									</router-link>
									<button class="btn_transparent" @click="deleteQuestion(item.id)">
										<i class="pe_icon pe-7s-junk trashColor"></i>
									</button>
								</td>
							</tr> -->
						</tbody>
						<!-- <pagination :limit="4" :data="getTestList" @pagination-change-page="getResults"></pagination> -->
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
			...mapActions('test',['actionTestList'])
		},
		mounted(){

		}
	}
</script>
<style scoped>
	
</style>
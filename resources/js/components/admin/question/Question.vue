<template>
	<div class="question">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-note"></i>
				    Вопросы
				</h4>
				<router-link class="btn btn-primary" to="/crm/question/add"><i class="fas fa-plus"></i> Добавить</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Направления</th>
							<th scope="col">Количество вопроса</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getQuestionList.data">
							<td scope="row">{{index+1}}</td>
							<td>{{item.name}}</td>
							<td>{{item.question_count}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/question/edit/${item.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteQuestion(item.id)">
									<i class="pe_icon pe-7s-junk trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getQuestionList" @pagination-change-page="getResults"></pagination>
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
			return{}
		},
		async mounted(){
			let page = 1
			await this.actionQuestionList(page)
		},
		computed:{
			...mapGetters('question',['getQuestionList']),
		},
		methods:{
			...mapActions('question',['actionQuestionList','actionDeleteQuestion','actionDeleteQuestion']),
			async getResults(page = 1){ 
				await this.actionQuestionList(page)
			},
			async deleteQuestion(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					await this.actionDeleteQuestion(id)
					await this.actionQuestionList(page)
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Категория удалено!',
				    })
				}
			}
		}
	}
</script>
<style scoped>
	
</style>
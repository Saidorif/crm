<template>
	<div class="question">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i data-v-956a9a24="" class="peIcon pe-7s-note"></i>
				    Question 
				</h4>
				<router-link class="btn btn-primary" to="/crm/question/add"><i class="fas fa-plus"></i> Add</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col">Категория</th>
							<th scope="col">Название</th>
							<th scope="col">Действия</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td scope="row">1</td>
							<td>2sads</td>
							<td>2sads</td>
							<td>
								<!-- <router-link tag="button" class="btn_transparent" :to='`/crm/question/edit/${item.id}`'> -->
								<router-link tag="button" class="btn_transparent" to='/crm/question/edit/1'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteQuestion(1)">
									<i class="pe_icon pe-7s-junk trashColor"></i>
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
		async mounted(){
			// await this.category()
		},
		computed:{
			...mapGetters('question',['getQuestionList'])
		},
		methods:{
			...mapActions('category',['actionCategoryList']),
			...mapActions('question',['actionQuestionList','actionDeleteQuestion']),
			async getResults(page = 1){ 
				await this.actionQuestionList(page)
			},
		}
	}
</script>
<style scoped>
	
</style>
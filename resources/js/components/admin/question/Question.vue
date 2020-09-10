<template>
	<div class="question">
		<Loader v-if="loading" />
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-note"></i>
				     {{ $t('admin_menu.questions') }}
				</h4>
				<router-link class="btn btn-primary" to="/crm/question/add"><i class="fas fa-plus"></i>  {{ $t('add_info') }}</router-link>
		  	</div>
		  	<div class="card-body">
			  <div class="table-responsive">
				<table class="table table-bordered text-center table-hover table-striped">
					<thead>
						<tr>
							<th scope="col">№</th>
							<th scope="col"> {{ $t('admin_menu.directions') }}</th>
							<th scope="col">{{ $t('number_question') }} </th>
							<th scope="col">{{ $t('action') }}</th>
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
							<!-- 	<button class="btn_transparent" @click="deleteQuestion(item.id)">
									<i class="pe_icon pe-7s-junk trashColor"></i>
								</button> -->
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
		import Loader from '../../Loader'
	export default{
		components:{
			Loader
		},
		data(){
			return{
				loading: true,
			}
		},
		async mounted(){
			let page = 1
			await this.actionQuestionList(page)
			this.loading = false
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
				if(confirm(this.$t('remove_item'))){
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
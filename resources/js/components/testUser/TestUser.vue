<template>
	<div class="test_user">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-browser"></i>
				    Test USER List 
				</h4>
		  	</div>
		  	<div class="card-body">
			  	<div class="table-responsive">
					<table class="table table-bordered text-center table-hover table-striped">
						<thead>
							<tr>
								<th scope="col">№</th>
								<th scope="col">Статус</th>
								<th scope="col">Количество вопроса</th>
								<th scope="col">Балл</th>
								<th scope="col">Дата</th>
								<th scope="col">Действия</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(item,index) in getTestUserList.data">
								<td scope="row">{{index+1}}</td>
								<td> 
									<div class="badge status_f_s" :class="status_class(item.status)">
										<b>{{word_to_russian(item.status)}}</b>
									</div> 
								</td>
								<td>{{item.limit}}</td>
								<td>{{percentage(item.limit,item.true_answers)}}</td>
								<td>{{item.created_at}}</td>
								<td>
									<router-link 
										tag="button" 
										class="btn_transparent" 
										:to='`/crm/test/test-result/${item.id}`'
										v-if="item.status == 'complete'"
									>
										<i class="pe_icon pe-7s-edit editColor"></i>
									</router-link>
									<router-link 
										tag="button" 
										class="btn_transparent" 
										:to='`/crm/test/test-user-start/${item.id}`'
									>
										<!-- v-if="item.status == 'start'" -->
										<i class="pe_icon pe-7s-play editColor"></i>
									</router-link>
								</td>
							</tr>
						</tbody>
						<pagination :limit="4" :data="getTestUserList" @pagination-change-page="getResults"></pagination>
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
		computed:{
			...mapGetters('test',['getTestUserList'])
		},
		methods:{
			...mapActions('test',['actionUserTestList']),
			async getResults(page = 1){ 
				await this.actionUserTestList(page)
			},
			percentage(limit,true_answers){
				let number = true_answers ? parseInt(true_answers)*100/parseInt(limit)+' %' : ''
				return number 
			},
			word_to_russian(word){
				if (word =='complete') {
					return 'завершено'
				}else if(word =='progress'){
					return 'не завершено'
				}else if(word =='start'){
					return 'новый тест'
				}
			},
			status_class(status){
				if (status =='complete') {
					return 'badge-success'
				}else if(status =='progress'){
					return 'badge-warning'
				}else if(status =='start'){
					return 'badge-primary'
				}
			}
		},
		async mounted(){
			let page = 1
			await this.actionUserTestList({page:page})
		}
	}
</script>
<style scoped>
	.status_f_s{
		font-size:12px;
	}
</style>
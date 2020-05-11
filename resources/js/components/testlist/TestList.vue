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
								<td>{{item.category.name}}</td>
								<td> 
									<div class="badge status_f_s" :class="item.status =='complete' ? 'badge-success' : 'badge-warning'">
										<b>{{word_to_russian(item.status)}}</b>
									</div> 
								</td>
								<td>{{item.limit}}</td>
								<td>{{percentage(item.limit,item.true_answers)}}</td>
								<td>
									<router-link tag="button" class="btn_transparent" :to='`/crm/test/test-result/${item.id}`'>
										<i class="pe_icon pe-7s-edit editColor"></i>
									</router-link>
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
			return{}
		},
		computed:{
			...mapGetters('test',['getTestList'])
		},
		methods:{
			...mapActions('test',['actionTestList']),
			async getResults(page = 1){ 
				await this.actionTestList(page)
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
				}
			}
		},
		async mounted(){
			let page = 1
			await this.actionTestList({page:page})
		}
	}
</script>
<style scoped>
	.status_f_s{
		font-size:12px;
	}
</style>
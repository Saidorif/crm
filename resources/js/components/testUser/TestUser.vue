<template>
	<div class="test_user">
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title">
				    <h4 class="title_user">
				    	<i class="peIcon pe-7s-browser"></i>
						{{ $t('admin_menu.test_list') }}(user) 
					</h4>
					<div class="add_user_btn">
			            <button type="button" class="btn btn-info toggleFilter" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>{{ $t('filter') }}
						</button>
		            </div>
		  		</div>
		    	<transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
				  			<div class="col-lg-4 form-group">
						  	 	<label for="date">{{ $t('date') }}</label>
							    <date-picker 
							    	lang="ru" 
							    	v-model="filter.date" 
							    	valueType="format" 
							    	format="YYYY-MM-DD"
						    	></date-picker>
			   			  	</div>
  					  		<div class="form-group col-lg-4">
	  							<label for="status">{{ $t('user_info.status.title') }}</label>
  								<select name="" v-model="filter.status" class="form-control" >
  									<option value="">{{ $t('user_info.status.choose') }}</option>
  									<option value="complete">{{ $t('user_info.status.complete') }}</option>
  									<option value="progress">{{ $t('user_info.status.progress') }}</option>
  									<option value="start"> {{ $t('user_info.status.start') }}</option>
  								</select>
					  			</div>		
						  	<div class="col-lg-4 form-group btn_search">
							  	<button type="button" class="btn btn-primary mr-2" @click.prevent="search">
							  		<i class="fas fa-search"></i>
								  	{{ $t('search') }}
							  	</button>
							  	<button type="button" class="btn btn-warning clear" @click.prevent="clear">
							  		<i class="fas fa-times"></i>
								  	
									  {{ $t('clean') }}
							  	</button>
					  	  	</div>	
				  		</div>
				  	</div>	
			  	</transition>
		  	</div>
		  	<div class="card-body">
			  	<div class="table-responsive">
					<table class="table table-bordered text-center table-hover table-striped">
						<thead>
							<tr>
								<th scope="col">№</th>
								<th scope="col">{{ $t('user_info.status.title') }}</th>
								<th scope="col"> {{$t('number_question') }}</th>
								<th scope="col"> {{$t('score') }}</th>
								<th scope="col">{{$t('date') }}</th>
								<th scope="col">{{$t('action') }}</th>
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
										v-if="item.status == 'start'"
									>
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
	import DatePicker from 'vue2-datepicker'
	import {mapActions, mapGetters} from 'vuex'
	import 'vue2-datepicker/index.css';
	export default{
		components:{
			DatePicker
		},
		data(){
			return{
				filterShow:false,
				filter:{
					status:'',
					date:'',
				},
				pageList:1,
			}
		},
		computed:{
			...mapGetters('test',['getTestUserList'])
		},
		methods:{
			...mapActions('test',['actionUserTestList']),
			async getResults(page = 1){ 
				await this.actionUserTestList({page: page,items:this.filter})
				this.pageList = page
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
			},
			async search(){
				let page = 1
				if(this.filter.status || this.filter.date){
					await this.actionUserTestList({page: page,items:this.filter})
				}
			},
			async clear(){
				if(this.filter.status || this.filter.date){
					this.filter.status = ''
					this.filter.date = ''
					let page  = 1
					await this.actionUserTestList({page: page,items:this.filter});
				}

			},
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
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
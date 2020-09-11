<template>
	<div class="test_list">
				<Loader v-if="loading" />
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title">
				    <h4 class="title_user">
				    	<i class="peIcon pe-7s-browser"></i>
						{{ $t('admin_menu.test_list') }}
					</h4>
					<div class="add_user_btn">
			            <button type="button" class="btn btn-info toggleFilter" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>
			            	 {{ $t('filter') }}
						</button>
		            </div>
		  		</div>
		    	<transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
  					  		<div class="form-group col-lg-3">
	  							<label for="fio">{{ $t('user_info.fio') }}</label>
	  							<input 
	  								type="text" 
	  								class="form-control" 
	  								id="fio" 
	  								:placeholder="$t('user_info.fio')"
	  								v-model="filter.fio"
  								>
				  			</div>
  					  		<div class="form-group col-lg-3">
	  							<label for="status">{{$t('user_info.status.title')}}</label>
  								<select name="" v-model="filter.status" class="form-control" >
  									<option value="">{{$t('user_info.status.choose')}}</option>
  									<option value="complete">{{$t('user_info.status.complete')}}</option>
  									<option value="progress"> {{$t('user_info.status.progress')}}</option>
  									<option value="start">{{$t('user_info.status.start')}}</option>
  								</select>
					  			</div>	
  					  		<div class="form-group col-lg-3">
	  							<label for="category_id"> {{$t('admin_menu.directions')}}</label>
  								<select name="" v-model="filter.category_id" class="form-control" >
  									<option value="">{{$t('admin_menu.select_directions')}}</option>
  									<option :value="cat.id" v-for="(cat,index) in getCategories" :key="cat.id">{{cat.name}}</option>
  								</select>
				  			</div>	
						  	<div class="col-lg-3 form-group btn_search">
							  	<button type="button" class="btn btn-primary mr-2" @click.prevent="search">
							  		<i class="fas fa-search"></i>
								  	{{$t('search')}}
							  	</button>
							  	<button type="button" class="btn btn-warning clear" @click.prevent="clear">
							  		<i class="fas fa-times"></i>
								  	{{$t('clean')}}
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
								<th scope="col">{{ $t('user_info.fio') }}</th>
								<th scope="col">{{ $t('test_position') }}</th>
								<th scope="col">{{ $t('user_info.status.title') }}</th>
								<th scope="col">{{ $t('number_question') }} </th>
								<th scope="col">{{ $t('score') }}</th>
								<th scope="col">{{ $t('test_start_time') }}</th>
								<th scope="col">{{ $t('result_show') }}</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(item,index) in getTestList.data">
								<td scope="row">{{index+1}}</td>
								<td>{{item.fio}}</td>
								<td>{{item.position}}</td>
								<td> 
									<div class="badge status_f_s" :class="status_class(item.status)">
										<b>{{word_to_russian(item.status)}}</b>
									</div> 
								</td>
								<td>{{item.limit}}</td>
								<td>{{ item.true_answers ?  parseFloat(percentage(item.limit,item.true_answers)).toFixed(1) : ''}}</td>
								<td>{{ item.ended_at}}</td>
								<td>
									<router-link tag="button" class="btn_transparent" :to='`/crm/test/test-result/${item.id}`'>
										<i class="pe_icon pe-7s-pen editColor"></i>
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
			import Loader from '../Loader'
	export default{
		components:{
			Loader
		},
		data(){
			return{
				filterShow:false,
				filter:{
					fio:'',
					status:'',
					category_id:'',
				},
				pageList:1,
				loading: true,
			}
		},
		computed:{
			...mapGetters('test',['getTestList']),
			...mapGetters('category',['getCategories'])
		},
		methods:{
			...mapActions('test',['actionTestList']),
			...mapActions('category',['actionCategoryList']),
			async getResults(page = 1){ 
				await this.actionTestList({page: page,items:this.filter})
				this.pageList = page
			},
			toggleFilter(){
				this.filterShow = !this.filterShow
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
					return 'новый тест!'
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
				if(this.filter.fio || this.filter.status || this.filter.category_id){
					await this.actionTestList({page: page,items:this.filter})
				}
			},
			async clear(){
				if(this.filter.fio || this.filter.status || this.filter.category_id){
					this.filter.fio = ''
					this.filter.status = ''
					this.filter.category_id = ''
					let page  = 1
					await this.actionTestList({page: page,items:this.filter});
				}

			},
		},
		async mounted(){
			let page = 1
			await this.actionTestList({page:page})
			await this.actionCategoryList()
			this.loading = false
		}
	}
</script>
<style scoped>
	.status_f_s{
		font-size:12px;
	}
	.editColor{
		font-size: 14px;
	}
</style>
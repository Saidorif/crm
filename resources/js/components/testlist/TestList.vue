<template>
	<div class="test_list">
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title">
				    <h4 class="title_user">
				    	<i class="peIcon pe-7s-browser"></i>
					    Test List 
					</h4>
					<div class="add_user_btn">
			            <button type="button" class="btn btn-info toggleFilter" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>
			            	Филтр
						</button>
		            </div>
		  		</div>
		    	<transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
  					  		<div class="form-group col-lg-3">
	  							<label for="fio">Ф.И.О</label>
	  							<input 
	  								type="text" 
	  								class="form-control" 
	  								id="fio" 
	  								placeholder="Ф.И.О..."
	  								v-model="filter.fio"
  								>
				  			</div>
  					  		<div class="form-group col-lg-3">
	  							<label for="status">Статус</label>
  								<select name="" v-model="filter.status" class="form-control" >
  									<option value="">Выберите статус</option>
  									<option value="complete">Завершено</option>
  									<option value="progress">Не завершено</option>
  									<option value="start">Новый тест</option>
  								</select>
					  			</div>	
  					  		<div class="form-group col-lg-3">
	  							<label for="category_id">Направления</label>
  								<select name="" v-model="filter.category_id" class="form-control" >
  									<option value="">Выберите направления</option>
  									<option :value="cat.id" v-for="(cat,index) in getCategories" :key="cat.id">{{cat.name}}</option>
  								</select>
				  			</div>	
						  	<div class="col-lg-3 form-group btn_search">
							  	<button type="button" class="btn btn-primary mr-2" @click.prevent="search">
							  		<i class="fas fa-search"></i>
								  	найти
							  	</button>
							  	<button type="button" class="btn btn-warning clear" @click.prevent="clear">
							  		<i class="fas fa-times"></i>
								  	сброс
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
									<div class="badge status_f_s" :class="status_class(item.status)">
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
			return{
				filterShow:false,
				filter:{
					fio:'',
					status:'',
					category_id:'',
				},
				pageList:1
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
		}
	}
</script>
<style scoped>
	.status_f_s{
		font-size:12px;
	}
</style>
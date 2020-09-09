<template>
	<div class="employee">
		<div class="card">
		  	<div class="card-header header_filter">
		  		<div class="header_title">
				    <h4 class="title_user">
				    	<i  class="peIcon pe-7s-users"></i>
					     {{ $t('admin_menu.employee') }} 
					</h4>
					<div class="add_user_btn">
			            <button type="button" class="btn btn-info toggleFilter" @click.prevent="toggleFilter">
						    <i class="fas fa-filter"></i>
			            	{{ $t('filter') }} 
						</button>
						<router-link class="btn btn-primary" to="/crm/employee/add"><i class="fas fa-plus mr-2"></i>{{ $t('add_info') }} </router-link>
		            </div>
		  		</div>
		    	<transition name="slide">
				  	<div class="filters" v-if="filterShow">
				  		<div class="row">
  					  		<div class="form-group col-lg-3">
	  							<label for="name">{{ $t('user_info.fio') }}</label>
	  							<input 
	  								type="text" 
	  								class="form-control" 
	  								id="name" 
	  								:placeholder="$t('user_info.fio')"
	  								v-model="filter.name"
  								>
				  			</div>
  					<!--   		<div class="form-group col-lg-3">
	  							<label for="category_id">Должность</label>
  								<select name="" v-model="filter.position_id" class="form-control" >
  									<option value="">Выберите должность!</option>
  									<option :value="position.id" v-for="(position,index) in getPositionList" :key="position.id">	
  										{{position.name}}
  									</option>
  								</select>
				  			</div>	 -->
  					  		<div class="form-group col-lg-3">
	  							<label for="category_id">{{$t('user_info.position')}}</label>
  								<select name="" v-model="filter.category_id" class="form-control" >
  									<option value=""> {{$t('admin_menu.select_directions')}}</option>
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
							<th scope="col">{{ $t('user_info.position') }}</th>
							<th scope="col">{{ $t('user_info.role') }}</th>
							<th scope="col">E-mail</th>
							<th scope="col">{{ $t('user_info.phone_number') }}</th>
							<th scope="col">{{ $t('action') }}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,index) in getEmployees.data">
							<td scope="row">{{index+1}}</td>
							<td>{{item.name}}</td>
							<td>{{item.position}}</td>
							<td>{{item.role ? item.role.name : ''}}</td>
							<td>{{item.email}}</td>
							<td>{{item.phone}}</td>
							<td>
								<router-link tag="button" class="btn_transparent" :to='`/crm/employee/edit/${item.id}`'>
									<i class="pe_icon pe-7s-edit editColor"></i>
								</router-link>
								<button class="btn_transparent" @click="deleteEmployee(item.id)">
									<i class="pe_icon pe-7s-trash trashColor"></i>
								</button>
							</td>
						</tr>
					</tbody>
					<pagination :limit="4" :data="getEmployees" @pagination-change-page="getResults"></pagination>
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
				filter:{
					name:'',
					category_id:'',
					// position_id:'',
				},
				filterShow:false,
			}
		},
		async mounted(){
			let page = 1;
			await this.actionEmployees({page:page,items:this.filter})
			await this.actionCategoryList()
			// await this.actionPositionList()
		},
		computed:{
			...mapGetters('employee',['getEmployees']),
			...mapGetters('category',['getCategories']),
			// ...mapGetters('position',['getPositionList'])
		},
		methods:{
			...mapActions('category',['actionCategoryList']),
			...mapActions('employee',['actionEmployees','actionDeleteEmployee']),
			// ...mapActions('position',['actionPositionList']),
			async getResults(page = 1){ 
				await this.actionEmployees({page:page,items:this.filter})
			},
			toggleFilter(){
				this.filterShow = !this.filterShow
			},
			async search(){
				let page = 1
				if(this.filter.name || this.filter.category_id || this.filter.position_id){
					await this.actionEmployees({page: page,items:this.filter})
				}
			},
			async clear(){
				if(this.filter.name || this.filter.category_id || this.filter.position_id){
					this.filter.name = ''
					this.filter.category_id = ''
					this.filter.position_id = ''
					let page  = 1
					await this.actionEmployees({page: page,items:this.filter})
				}

			},
			async deleteEmployee(id){
				if(confirm("Вы действительно хотите удалить?")){
					let page = 1
					await this.actionDeleteEmployee(id)
					await this.actionEmployees({page: page,items:this.filter})
					toast.fire({
				    	type: 'success',
				    	icon: 'success',
						title: 'Пользователь удалено!',
				    })
				}
			}
		}
	}
</script>
<style scoped>
	
</style>
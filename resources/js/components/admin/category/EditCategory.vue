<template>
	<div class="category">
				<Loader v-if="loading" />
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-drawer"></i>
				    {{ $t('admin_menu.edit_directions') }}
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/category"><span class="peIcon pe-7s-back"></span> {{ $t('back') }}</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveCategory" >
					<div class="row">
					  <div class="form-group col-md-6">
					    <label for="categoryName">{{ $t('directions_name') }} </label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="categoryName" 
					    	:placeholder="$t('directions_name')"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"  
				    	>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="qty">{{$t('count')}}</label>
					    <input 
					    	type="number" 
					    	class="form-control input_style" 
					    	id="qty" 
					    	:placeholder="$t('count')"
					    	v-model="form.qty"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"  
				    	>
					  </div>
					  <div class="form-group col-md-6">
					    <label for="time">{{$t('time')}}</label>
					    <input 
					    	type="number" 
					    	class="form-control input_style" 
					    	id="time" 
					    	:placeholder="$t('time')"
					    	v-model="form.time"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"  
				    	>
					  </div>
					  <div class="form-group col-md-12 d-flex justify-content-end">
					  	<button type="submit" class="btn btn-primary btn_save_category">
					  		<i class="fas fa-save"></i>
						  	{{ $t('save') }}
						</button>	
				  	  </div>
					</div>
				</form>
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
				form:{
					id:null,
					name:'',
					qty:'',
					time:'',
				},
				requiredMessage:null,
				requiredInput:false,
				loading: true
			}
		},
		computed:{
			...mapGetters('category',['getCategoryList','getMassage','getCategory'])
		},
		async mounted(){
			let data = {
				id:this.$route.params.categoryId,
				name:this.form.name
			}
			await this.actionEditCategory(data)
			this.form = this.getCategory
			this.loading = false;
		},
		methods:{
			...mapActions('category',['actionCategoryPag','actionEditCategory','actionUpdateCategory']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveCategory(){
				if (this.form.name != '' && this.form.qty != '' && this.form.time != ''){
					await this.actionUpdateCategory(this.form)
					await this.actionCategoryPag()
					this.$router.push("/crm/category");
					this.requiredInput =false
				}else{
					this.requiredInput =true
				}
			}
		}
	}
</script>
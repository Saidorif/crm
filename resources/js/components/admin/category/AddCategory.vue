<template>
	<div class="category">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="nav-icon fas fa-box"></i>
				    Add Category
				</h4>
				<router-link class="btn btn-primary" to="/crm/category"><i class="fas fa-arrow-circle-left"></i> Back</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveCategory" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="categoryName">Category Name</label>
					    <input 
					    	type="text" 
					    	class="form-control" 
					    	id="categoryName" 
					    	placeholder="Category Name"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"  
				    	>
					  </div>
					 
					  <div class="form-group col-lg-3 form_btn">
					  	<button type="submit" class="btn btn-primary">
					  		<i class="fas fa-save"></i>
						  	Сохранить
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
	export default{
		data(){
			return{
				form:{
					name:''
				},
				requiredMessage:null,
				requiredInput:false,
			}
		},
		computed:{
			...mapGetters('category',['getCategoryList','getMassage'])
		},
		methods:{
			...mapActions('category',['actionCategoryList','actionAddCategory']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveCategory(){
				if (this.form.name != '' && this.form.name != null){
					await this.actionAddCategory(this.form)
					await this.actionCategoryList()
					this.$router.push("/crm/category");
					this.requiredInput =false
				}else{
					this.requiredInput =true
				}
			}
		}
	}
</script>
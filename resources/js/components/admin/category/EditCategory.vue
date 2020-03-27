<template>
	<div class="category">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="nav-icon fas fa-box"></i>
				    Edit Category
				</h4>
				<router-link class="btn btn-primary" to="/crm/category"><i class="fas fa-arrow-circle-left"></i> Back</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveCategory">
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
					id:null,
					name:''
				},
				requiredMessage:null,
				requiredInput:false,
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
		},
		methods:{
			...mapActions('category',['actionCategoryList','actionEditCategory','actionUpdateCategory']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveCategory(){
				if (this.form.name != '' && this.form.name != null) {
					await this.actionUpdateCategory(this.form)
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
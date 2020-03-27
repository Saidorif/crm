<template>
	<div class="category">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-drawer"></i>
				    Add Category
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/category"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveCategory" >
					<div class="row">
					  <div class="form-group col-md-9">
					    <label for="categoryName">Category Name</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="categoryName" 
					    	placeholder="Category Name"
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"  
				    	>
					  </div>
					 
					  <div class="form-group col-lg-3 form_btn">
					  	<button type="submit" class="btn btn-primary btn_save_category">
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
			...mapActions('category',['actionCategoryPag','actionAddCategory']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
			async saveCategory(){
				if (this.form.name != '' && this.form.name != null){
					await this.actionAddCategory(this.form)
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
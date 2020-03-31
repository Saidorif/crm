<template>
	<div class="start_test">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-browser"></i>
				    Start Test for guest 
				</h4>
		  	</div>
		  	<div class="card-body">
			  <form @submit.prevent.enter="startTest" >
					<div class="row">
						<div class="form-group col-md-6">
						    <label for="categoryName">Ф.И.О</label>
						    <input 
						    	type="text" 
						    	class="form-control input_style" 
						    	id="categoryName" 
						    	placeholder="Ф.И.О"
						    	v-model="form.fio"
						    	:class="isRequired(form.fio) ? 'isRequired' : ''"  
					    	>
					  	</div>
						<div class="form-group col-md-6">
						    <label for="category">Направления</label>
						    <select 
						    	class="form-control" 
						    	id="category" 
						    	:class="isRequired(form.category_id) ? 'isRequired' : ''"  
						    	v-model="form.category_id">
						      <option value="" selected disabled>Выберите направление</option>
						      <option :value="category.id" v-for="(category,index) in getCategories">{{category.name}}</option>
						    </select>
					  	</div>
						<div class="form-group col-md-6">
						    <label for="limit">Количество вопроса</label>
						    <input 
							    type="number"
							    min="1"
						    	class="form-control" 
						    	id="limit" 
						    	:class="isRequired(form.limit) ? 'isRequired' : ''"  
						    	v-model="form.limit"
					      	/>
					  	</div>
				  		<div class="form-group col-lg-6 form_btn">
						  	<button type="submit" class="btn btn-primary btn_save_category">
						  		<i class="far fa-play-circle"></i>
							  	начать тест
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
					category_id:'',
					fio:'',
					limit:'',
				},
				requiredInput:false,
			}
		},
		computed:{
			...mapGetters('test',['getTests','getMassage']),
			...mapGetters('category',['getCategories'])
		},
		async mounted(){
			await this.actionCategoryList()
		},
		methods:{
			...mapActions('category',['actionCategoryList']),
			...mapActions('test',['actionStartTest']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    async startTest(){
		    	if (this.form.category_id && this.form.fio &&  this.form.limit) {
		    		await this.actionStartTest(this.form)
		    		if (this.getTests.success){
		    			this.$router.push("/crm/test/test-for-guest");
		    			toast.fire({
							type: "success",
							icon: 'success',
							title: "Тест начался!"
						});
		    		}
		    		else if(this.getTests.error && this.getTests.message == 'Big limit...'){
		    			toast.fire({
							type: "error",
							icon: 'error',
							title: "Эти типы вопросов не достаточно в базе данных!"
						});
		    		}
		    	}else{
		    		this.requiredInput = true
		    	}
		    }
		}
	}
</script>
<style scoped>
	
</style>
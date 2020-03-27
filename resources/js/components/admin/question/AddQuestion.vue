<template>
	<div class="add_question">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-drawer"></i>
				    Add Question
				</h4>
				<router-link class="btn btn-primary" to="/crm/question"><i class="fas fa-arrow-circle-left"></i> Back</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveQuestion" >
					<div class="row">
					  <div class="form-group col-md-12">
					    <label for="categoryName">Category Name</label>
					    <select 
					    	class="form-control" 
					    	:class="isRequired(form.category_id) ? 'redFrame' : '' " 
					    	id="countryName" 
					    	v-model="form.category_id">
					      <option value="" selected disabled>Выберите категорию</option>
					      <!-- <option :value="category.id" v-for="(category,index) in getListCountry">{{category.name}}</option> -->
					    </select>
					  </div>
					  <div class="form-group col-md-12">
					    <label for="questionName">Question</label>
					    <textarea 
					    	class="form-control input_style" 
					    	id="questionName" 
					    	placeholder="Question..."
					    	v-model="form.name"
					    	:class="isRequired(form.name) ? 'isRequired' : ''"
				    	></textarea>
					  </div>
				  	</div>
				  	<div class="answer_head">
				  		<h3>Answers</h3>
			  		 	<button type="button" class="btn btn-primary" @click="addAnswer">
			  		 		<i class="fas fa-plus"></i> Add answer
				  		 </button>
				  	</div>
			  		<div class="row" v-for="(answer,index) in form.variants">
					  <div class="form-group col-md-6">
					    <label for="categoryName">{{index + 1}} ) Answer Name</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="answer" 
					    	placeholder="Answer..."
					    	v-model="form.variants[index].title"
					    	:class="isRequired(form.variants[index].title) ? 'isRequired' : ''"
					    >
					  </div>
					  <div class="form-group col-md-2">
					  	<template v-if="form.variants[index].title != ''">
						    <label for="checked">Right Answer</label>
						    <input 
							    type="radio" 
						    	class="form-control input_style" 
						    	id="checked" 
						    	placeholder="Answer..."
						    	name="checked"
						    	v-model="form.variants[index].checked"
						    	value="1"
						    >
					  	</template>
					  </div>
					  <div class="form-group col-md-2" v-if="form.variants.length > 1">
					    <button type="submit" class="btn btn-danger btn_save_category" @click="removeAnswer(index)">
					  		<i class="fas fa-trash"></i>
						</button>	
					  </div>
					</div>
					<div class="row">
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
					name:'',
					category_id:'',
					variants:[
						{
							title:'',checked:0
						}
					],
				},
				requiredInput:false
			}
		},
		computed:{
			...mapGetters('question',['getQuestionList','getMassage'])
		},
		methods:{
			...mapActions('question',['actionQuestionList','actionAddQuestion']),
			...mapActions('question',['actionCategoryList']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    addAnswer(){
		    	let value = {title:'',checked:0}
		    	let check = false
		    	for(let key in this.form.variants){
		    		if (this.form.variants[key].title != ''){
	    				check = true
		    		}else{
		    			alert('error')
	    				return false
		    		}
		    	}
		    	if (check) {
		    		this.form.variants.unshift(value)
		    		check = false
		    	}
		    },
		    removeAnswer(index){
		    	Vue.delete(this.form.variants,index)
		    },
			async saveQuestion(){
				console.log(this.form)
				// this.$router.push("/crm/question");
			}
		}
	}
</script>
<style scoped>
	
</style>
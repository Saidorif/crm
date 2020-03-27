<template>
	<div class="edit_question">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-drawer"></i>
				    Edit Question
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
					    	:class="isRequired(form.category_id) ? 'isRequired' : '' " 
					    	id="countryName" 
					    	v-model="form.category_id">
					      <option value="" selected disabled>Выберите категорию</option>
					      <option :value="category.id" v-for="(category,index) in getCategories">{{category.name}}</option>
					    </select>
					  </div>
					  <div class="form-group col-md-12">
					    <label for="questionName">Question</label>
					    <textarea 
					    	class="form-control input_style" 
					    	id="questionName" 
					    	placeholder="Question..."
					    	v-model="form.title"
					    	:class="isRequired(form.title) ? 'isRequired' : ''"
				    	></textarea>
					  </div>
				  	</div>
				  	<div class="answer_head mb-2">
				  		<h3>Answers</h3>
			  		 	<button type="button" class="btn btn-primary" @click="addAnswer">
			  		 		<i class="fas fa-plus"></i> Add answer
				  		 </button>
				  	</div>
			  		<div class="row align-items-end" v-for="(answer,index) in form.variants">
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
					  <div class="form-group col-md-2 radio_style_block">
					  	<template v-if="form.variants[index].title != ''">
						    <input type="radio" class="form-control input_style radio_style_input" :id="'is_true'+index" 
						    	placeholder="Answer..."
						    	name="is_true"
						    	v-model="form.variants[index].is_true"
						    	value="true"
						    >
						    <label :for="'is_true'+index" class="radio_style_label" >Right Answer</label>

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
					id:'',
					title:'',
					category_id:'',
					variants:[
						{
							title:'',is_true:'false'
						}
					],
				},
				requiredInput:false
			}
		},
		computed:{
			...mapGetters('question',['getQuestionList','getMassage','getQuestion']),
			...mapGetters('category',['getCategories']),
			
		},
		methods:{
			...mapActions('category',['actionCategoryList']),
			...mapActions('question',['actionQuestionList','actionUpdateQuestion','actionEditQuestion']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    checkRadioBtn(){
				let new_arr = this.form.variants.map(item=>{
					return item.is_true
				})
				return new_arr.includes('true')
			},
		    addAnswer(){
		    	let value = {title:'',is_true:'false'}
		    	let check = false
		    	for(let key in this.form.variants){
		    		if(this.form.variants[key].title != ''){
						check = true
						this.requiredInput = false
		    		}else{
						this.requiredInput = true
						toast.fire({
							type: "error",
							icon: 'error',
							title: "Поле не может быть пустым"
						});
	    				return false
		    		}
		    	}
		    	if (check){
		    		this.form.variants.unshift(value)
		    		check = false
		    	}
		    },
		    removeAnswer(index){
		    	Vue.delete(this.form.variants,index)
		    },
			async saveQuestion(){
				if (this.form.title != '' && this.form.category_id != '') {
					if (this.checkRadioBtn()) {
						console.log(this.form)
						// await this.actionUpdateQuestion(this.form)
						// this.$router.push("/crm/question");
						toast.fire({
							type: "success",
							icon: 'success',
							title: "Вопрос изменено!"
						});
					}else{
						toast.fire({
							type: "error",
							icon: 'error',
							title: "Выберите правильный ответ!"
						});
					}
				}else{
					this.requiredInput = true
				}
			}
		},
		async mounted(){
			let data = {
				id:this.$route.params.questionId,
			}
			await this.actionCategoryList()
			await this.actionEditQuestion(data)
			this.form = this.getQuestion
		}
	}
</script>
<style scoped>
	
</style>
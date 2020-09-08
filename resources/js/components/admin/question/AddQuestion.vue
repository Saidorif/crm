<template>
	<div class="add_question">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i class="peIcon pe-7s-drawer"></i>
				    Добавить вопрос
				</h4>
				<router-link class="btn btn-primary back_btn" to="/crm/question"><span class="peIcon pe-7s-back"></span> Назад</router-link>
		  	</div>
		  	<div class="card-body">
		  		<form @submit.prevent.enter="saveQuestion" >
					<div class="row">
					  <div class="form-group col-md-12">
					    <label for="categoryName">Управление</label>
					    <select 
					    	class="form-control" 
					    	:class="isRequired(form.category_id) ? 'isRequired' : '' " 
					    	id="countryName" 
					    	v-model="form.category_id">
					      <option value="" selected disabled>Выберите управление</option>
					      <option :value="category.id" v-for="(category,index) in getCategories">{{category.name}}</option>
					    </select>
					  </div>
				  	</div>
			  		<div class="row align-items-end" v-for="(variant,index) in form.variants">
			  			<hr>
					  	<div class="form-group col-md-12">
						    <label for="questionName">
						    	<div class="d-flex justify-content-between">
							    	<h3 class="mr-5">
							    		<b>{{index + 1}}) Вопрос</b>
							    	</h3>
							    	<button 
							    		type="submit" 
							    		class="btn btn-danger btn_save_category" 
							    		@click="removeAnswer(index)"
							    		v-if="form.variants.length > 1"
						    		>
								  		<i class="fas fa-trash"></i>
								  		Удалить вопрос № <em>{{index + 1}}</em>
									</button>
						    	</div>
						    </label>
						    <textarea 
						    	class="form-control input_style" 
						    	id="questionName" 
						    	placeholder="Вопрос..."
						    	v-model="form.variants[index].question_title"
						    	:class="isRequired(form.variants[index].question_title) ? 'isRequired' : ''"
					    	></textarea>
					  	</div>
					  	<div class="col-md-12">
					  	  	<div class="answer_head mb-2">
					  			<h3>Ответы</h3>
					  	  	</div>
					  	  	<div v-for="(answer,key) in variant.answers" class="row">
							  <div class="form-group col-md-6">
							    <label :id="'answer'+key">{{key + 1}} ) Ответ</label>
							    <input 
							    	type="text" 
							    	class="form-control input_style" 
							    	:id="'answer'+key" 
							    	placeholder="Ответ..."
							    	v-model="answer.title"
							    	:class="isRequired(answer.title) ? 'isRequired' : ''"
							    >
							  </div>
							  <div class="form-group col-md-2 radio_style_block">
							  	<template v-if="answer.title != ''">
								    <input type="radio" class="form-control input_style radio_style_input" 
								    	:id="'is_true'+index+key" 
								    	placeholder="Ответ..."
								    	:name="'is_true'+index"
								    	v-model="answer.is_true"
								    	value="1"
								    >
								    <label :for="'is_true'+index+key" class="radio_style_label" >Правильный ответ</label>
							  	</template>
							  </div>
					  	  	</div>
				  	  	</div>
					</div>
					<div class="row">
						<div class="form-group col-lg-12 d-flex justify-content-end">
							<button type="button" class="btn btn-secondary mr-3" @click="addAnswer">
				  		 		<i class="fas fa-plus"></i>
				  		 		Добавить ответ
				  		 	</button>
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
					category_id:'',
					variants:[
						{
							question_title:'',
							answers:[
								{
									title:'',is_true:0
								},
								{
									title:'',is_true:0
								},
								{
									title:'',is_true:0
								},
								{
									title:'',is_true:0
								},
							]
						},
					],
				},
				requiredInput:false
			}
		},
		computed:{
			...mapGetters('question',['getQuestionList','getMassage']),
			...mapGetters('category',['getCategories']),
		},
		methods:{
			...mapActions('category',['actionCategoryList']),
			...mapActions('question',['actionQuestionList','actionAddQuestion']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    checkRadioBtn(){
				let counter = null
				this.form.variants.map((items,index)=>{
					items.answers.map((item,key)=>{
						if (item.is_true == 1){
							counter = counter + parseInt(item.is_true) 
						}
					})
				})
				if(this.form.variants.length == counter){
					return true
				}else{
					return false
				}
			},		
		    addAnswer(){
		    	let value = {
					question_title:'',
					answers:[
						{
							title:'',is_true:0
						},
						{
							title:'',is_true:0
						},
						{
							title:'',is_true:0
						},
						{
							title:'',is_true:0
						},
					]
				}
	    		this.form.variants.push(value)
		    },
		    removeAnswer(index){
		    	if (index != 0) {
			    	Vue.delete(this.form.variants,index)
		    	}
		    },
			async saveQuestion(){
				if (this.form.category_id != '') {
					if (this.checkRadioBtn()) {
					await this.actionAddQuestion(this.form)
					toast.fire({
						type: "success",
						icon: 'success',
						title: "Вопрос добавлено!"
					});
					this.$router.push("/crm/question");
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
			await this.actionCategoryList()
		}
	}
</script>
<style scoped>
	
</style>
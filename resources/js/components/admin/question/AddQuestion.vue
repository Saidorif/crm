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
					  <div class="form-group col-md-12">
					    <label for="questionName">Вопрос</label>
					    <textarea 
					    	class="form-control input_style" 
					    	id="questionName" 
					    	placeholder="Вопрос..."
					    	v-model="form.title"
					    	:class="isRequired(form.title) ? 'isRequired' : ''"
				    	></textarea>
					  </div>
					  <div class="form-group col-md-12">
					    <label for="time">Время (в секунде)</label>
					    <input
					    	type="number" 
					    	min="1"
					    	class="form-control input_style" 
					    	id="time" 
					    	placeholder="Время..."
					    	v-model="form.time"
					    	:class="isRequired(form.time) ? 'isRequired' : ''"
				    	/>
					  </div>
				  	</div>
				  	<div class="answer_head mb-2">
				  		<h3>Ответы</h3>
			  		 	<button type="button" class="btn btn-primary" @click="addAnswer">
			  		 		<i class="fas fa-plus"></i> Добавить ответ
				  		 </button>
				  	</div>
			  		<div class="row align-items-end" v-for="(answer,index) in form.variants">
					  <div class="form-group col-md-6">
					    <label for="categoryName">{{index + 1}} ) Ответ</label>
					    <input 
					    	type="text" 
					    	class="form-control input_style" 
					    	id="answer" 
					    	placeholder="Ответ..."
					    	v-model="form.variants[index].title"
					    	:class="isRequired(form.variants[index].title) ? 'isRequired' : ''"
					    >
					  </div>
					  <div class="form-group col-md-2 radio_style_block">
					  	<template v-if="form.variants[index].title != ''">
						    <input type="radio" class="form-control input_style radio_style_input" 
						    	:id="'is_true'+index" 
						    	placeholder="Ответ..."
						    	name="is_true"
						    	v-model="form.variants[index].is_true"
						    	value="1"
						    >
						    <label :for="'is_true'+index" class="radio_style_label" >Правильный ответ</label>
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
					title:'',
					category_id:'',
					time:'',
					variants:[
						{
							title:'',is_true:0
						}
					],
				},
				requiredInput:false
			}
		},
		computed:{
			...mapGetters('question',['getQuestionList','getMassage']),
			...mapGetters('category',['getCategories'])		
		},
		methods:{
			...mapActions('category',['actionCategoryList']),
			...mapActions('question',['actionQuestionList','actionAddQuestion']),
			isRequired(input){
	    		return this.requiredInput && input === '';
		    },
		    checkRadioBtn(){
				let new_arr = this.form.variants.map(item=>{
					return parseInt(item.is_true)
				})
				return new_arr.includes(1)
			},
		    addAnswer(){
		    	let value = {title:'',is_true:0}
		    	let check = false
		    	for(let key in this.form.variants){
		    		if (this.form.variants[key].title != ''){
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
		    	if (check) {
		    		this.form.variants.unshift(value)
		    		check = false
		    	}
		    },
		    removeAnswer(index){
		    	Vue.delete(this.form.variants,index)
		    },
			async saveQuestion(){
				if (this.form.title != '' && this.form.category_id != '' && this.form.time != '') {
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
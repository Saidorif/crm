<template>
	<div class="add_employee">
		<div class="card">
		  	<div class="card-header">
		      <h3 class="card-title title_user mb-0"><i class="peIcon pe-7s-user"></i>Add Employee</h3>
		  	</div>
		  	<form role="form" @submit.prevent.enter="sendEmployee" enctype="multipart/form-data">
		      <div class="card-body d-flex flex-wrap">
		        <div class="form-group col-md-6">
		          <label for="name">Fullname</label>
		          <input 
		          	type="text" 
		          	class="form-control input_style" 
		          	id="name" 
		          	:class="isRequired(form.name) ? 'isRequired' : ''" 
		          	placeholder="Fullname"
		          	v-model="form.name"
		      	>
		        </div>
		        <div class="form-group col-md-6">
				    <label for="positon">Должность</label>
				    <select 
				    	class="form-control" 
				    	:class="isRequired(form.position_id) ? 'isRequired' : '' " 
				    	id="positon" 
				    	v-model="form.position_id">
				      <option value="" selected disabled>Выберите Должность</option>
				      <option :value="position.id" v-for="(position,index) in getPositionList">{{position.name}}</option>
				    </select>
			  	</div>
		        <div class="form-group col-md-6">
				    <label for="role">Role</label>
				    <select 
				    	class="form-control" 
				    	:class="isRequired(form.role_id) ? 'isRequired' : '' " 
				    	id="countryName" 
				    	v-model="form.role_id">
				      <option value="" selected disabled>Выберите рол</option>
				      <option :value="role.id" v-for="(role,index) in getRoleList">{{role.name}}</option>
				    </select>
			  	</div>
		        <div class="form-group col-md-6">
		          <label for="exampleInputEmail1">Email</label>
		          <input 
		          	type="email" 
		          	class="form-control input_style"
		          	:class="isRequired(form.email) ? 'isRequired' : ''"  
		          	id="exampleInputEmail1" 
		          	placeholder="Enter email"
		          	v-model="form.email"
		          	@blur="checkEmailInput"
		      	>
		      	<small class="redText" v-if="emailError">Email почта занят!</small>
		        </div>
		        <div class="form-group col-md-6">
	          		<label for="exampleInputPassword1">Password</label>
		          	<input 
			          	type="password" 
			          	class="form-control input_style" 
			          	id="exampleInputPassword1" 
			          	placeholder="Password.."
			          	:class="isRequired(form.password) ? 'isRequired' : ''"  
			          	v-model="form.password"
			      	>
		        </div>
		        <div class="form-group col-md-6">
		          <label for="ConfirmPassword1">Confirm Password</label>
		          <input 
		          	type="password" 
		          	class="form-control input_style" 
		          	id="ConfirmPassword1" 
		          	placeholder="Confirm Password.."
		          	v-model="form.confirm_password"
		          	:class="isRequired(form.confirm_password) ? 'isRequired' : ''"  
		          	@input="confirmPassword()"
		  	      >
			        <small class="redText" v-if="checkPassword"><b>Пароль не совпадает</b></small>
		        </div>
		        <div class="form-group col-md-6">
				    <label for="category">Управления</label>
				    <select 
				    	class="form-control" 
				    	id="category" 
				    	v-model="form.category_id">
				      <option value="" selected disabled>Выберите управление</option>
				      <option :value="category.id" v-for="(category,index) in getCategories">{{category.name}}</option>
				    </select>
			  	</div>
		        <div class="form-group col-md-6">
		          <label for="phone">Phone</label>
		          <input 
		          	type="text" 
		          	class="form-control input_style" 
		          	id="phone" 
		          	placeholder="Phone.."
		          	v-model="form.phone"
		      	>
		        </div>
		        <div class="form-group col-md-6">
		          <label for="address">Address</label>
		          <input 
		          	type="text" 
		          	class="form-control input_style" 
		          	id="address" 
		          	placeholder="Address.."
		          	v-model="form.address"
		      		>
		        </div>
		        <div class="form-group col-md-6">
	          		<label for="file">File</label>
		          	<input 
			          	type="file" 
			          	class="form-control input_style" 
			          	id="file" 
			          	@change="changeFile($event)"
			      	>
		      	<img :src="photoImg(form.file)" alt="" class="img_blank" width="50">
		        </div>
		        <div class="form-group col-md-6">
	          		<label for="image">Photo</label>
	          		<input 
			          	type="file" 
			          	class="form-control input_style" 
			          	id="image" 
			          	@change="changePhoto($event)"
      				>
			      	<img :src="photoImg(form.image)" alt="" class="img_blank" width="50">
		        </div>
				<div class="row col-md-12" v-for="(ex, index) in form.experience">
					<div class="col-12 d-flex justify-content-end" v-if="index != 0">
						<button type="button" class="btn btn-primary mr-3" @click="removeExperience(ex, index)"> <i class="fas fa-plus"></i> Remove experience</button>
					</div>
					<div class="form-group col-md-3">
						<label for="company">Company name</label>
						<input 
							type="text" 
							class="form-control input_style" 
							id="company" 
							:class="isRequired(ex.company) ? 'isRequired' : ''" 
							placeholder="Company name"
							v-model="ex.company">
					</div>
					<div class="form-group col-md-3">
						<label for="position">position name</label>
						<input 
							type="text" 
							class="form-control input_style" 
							id="position" 
							:class="isRequired(ex.position) ? 'isRequired' : ''" 
							placeholder="position"
							v-model="ex.position">
					</div>
					<div class="form-group col-md-3">
						<label for="date_from">date_from</label>
						<input 
							type="date" 
							class="form-control input_style" 
							id="date_from" 
							:class="isRequired(ex.date_from) ? 'isRequired' : ''" 
							placeholder="date_from"
							v-model="ex.date_from">
					</div>
					<div class="form-group col-md-3">
						<label for="date_to">date_to</label>
						<input 
							type="date" 
							class="form-control input_style" 
							id="date_to" 
							:class="isRequired(ex.date_to) ? 'isRequired' : ''" 
							placeholder="date_to"
							v-model="ex.date_to">
					</div>
					<div class="form-group col-md-6">
						<label for="address">address</label>
						<input 
							type="text" 
							class="form-control input_style" 
							id="address" 
							placeholder="address"
							v-model="ex.address">
					</div>
					<div class="form-group col-md-6">
						<label for="description">description</label>
						<input 
							type="text" 
							class="form-control input_style" 
							id="description" 
							placeholder="description"
							v-model="ex.description">
					</div>
					<hr>
				</div>
		        <div class="col-12 d-flex justify-content-end">
		          <button type="button" class="btn btn-primary mr-3" @click="addExperience()"> <i class="fas fa-plus"></i> Add experience</button>
		          <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Сохранить</button>
		        </div>
		      </div>
		  	</form>
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
					email:'',
					password:'',
					confirm_password:'',
					category_id:'',
					address:'',
					role_id:'',
					position_id:'',
					phone:'',
					image:'',
					file:'',
					text:'',
					experience: [
						{company: '', date_from: '', date_to: '', address: '', position: '', description: ''}
					]
				},
				requiredInput:false,
				checkPassword:false,
				emailError:false,
			}
		},
		async mounted(){
			await this.actionRoleList()
     	 	await this.actionCategoryList();
     	 	await this.actionPositionList();
		},
		computed:{
			...mapGetters('employee',['getMassage']),
			...mapGetters('role',['getRoleList']),
			...mapGetters('category',['getCategories']),
			...mapGetters('position',['getPositionList'])
		},
		methods:{
			...mapActions('category',['actionCategoryList']),		
			...mapActions('role',['actionRoleList']),
			...mapActions('employee',['actionAddEmployee','actionCheckEmail']),
			...mapActions('position',['actionPositionList']),
			confirmPassword(){
		      	if(this.form.password && this.form.confirm_password){
			      	if(this.form.password != this.form.confirm_password){
				        this.checkPassword = true
			      	} else {
				        this.checkPassword = false
			      	}
		      	}
		    },
		    photoImg(img){
				if (img.length < 100) {
					// return '/img/'+img;
				}else{
					return img
				}
			},
		    changeFile(event){
		    	let file = event.target.files[0];
		      	if (file.size > 1048576){
			          swal.fire({
			            type: 'error',
			            icon: 'error',
			            title: 'Ошибка',
			            text:'Размер файл не должно быть больше 1мб',
			          })
		      	}else{
			          let reader = new FileReader();
			          reader.onload = event=> {
			            this.form.file = event.target.result;
			          };
			          reader.readAsDataURL(file);
		      	}
		    },
		    changePhoto(event){
				let file = event.target.files[0];
				if(event.target.files[0]['type'] ==='image/png' || event.target.files[0]['type'] ==='image/jpeg' || event.target.files[0]['type'] ==='image/jpg'){
					if (file.size > 1048576) {
						swal.fire({
							type: 'error',
							title: 'Ошибка',
							text:'Размер изображения больше лимита',
						})
					}else{
						let reader = new FileReader();
						reader.onload = event => {
							this.form.image = event.target.result;
						};
						reader.readAsDataURL(file);
						
					}
				}else{
					swal.fire({
						type: 'error',
						title: 'Ошибка',
						text:'Картинка должна быть только png,jpg,jpeg!',
					})
				}
			},
			isRequired(input){
				if(input != null){
	    			return this.requiredInput && input === '';
				}
		    },
		    async sendEmployee(){
				if (this.form.name && this.form.email && this.form.password && this.form.confirm_password &&  this.form.role_id && this.checkPassword == false) {
					await this.actionAddEmployee(this.form)
					if (this.getMassage.success) {
						this.$router.push("/crm/employee");
						this.requiredInput =false
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: 'Ползователь добавлено!',
					    })
					}
				}else{
					this.requiredInput = true
				}
			},
			async checkEmailInput(){
				await this.actionCheckEmail({email:this.form.email})
				if (this.getMassage.error && this.getMassage.message.email == 'The email has already been taken.') {
					this.emailError = true
				}else{
					this.emailError = false
				}
			},
			addExperience(){
				let item = {company: '', date_from: '', date_to: '', address: '', position: '', description: ''};
				this.form.experience.push(item)
			},
			removeExperience(ex, index){
				this.form.experience.splice(index, 1);
			}
		},
	}
</script>
<style scoped>
	
</style>
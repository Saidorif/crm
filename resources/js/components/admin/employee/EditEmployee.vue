<template>
	<div class="edit_employee">
		<div class="card">
		  	<div class="card-header">
		      <h3 class="card-title title_user mb-0"><i class="peIcon pe-7s-user"></i>Edit Employee</h3>
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
		          	v-model="form.passwordConfirm"
		          	:class="isRequired(form.passwordConfirm) ? 'isRequired' : ''"  
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
		        <div class="form-group col-md-12">
		          <label for="text">Text</label>
		          <textarea 
		          	rows="10" 
		          	class="form-control input_style" 
		          	id="text" 
		          	v-model="form.text"
		  	      ></textarea>
		        </div>
		        <div class="col-12 d-flex justify-content-end">
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
					id:'',
					name:'',
					email:'',
					password:'',
					passwordConfirm:'',
					category_id:'',
					address:'',
					role_id:'',
					phone:'',
					image:'',
					file:'',
					text:'',
				},
				requiredInput:false,
				checkPassword:false,
				emailError:false,
			}
		},
		async mounted(){
			await this.actionRoleList()
     	 	await this.actionCategoryList()
     	 	await this.actionEditEmployee({id:this.$route.params.employeeId})
     	 	this.form = this.getEmployee

		},
		computed:{
			...mapGetters('employee',['getMassage','getEmployee']),
			...mapGetters('role',['getRoleList']),
			...mapGetters('category',['getCategories'])
		},
		methods:{
			...mapActions('category',['actionCategoryList']),		
			...mapActions('role',['actionRoleList']),
			...mapActions('employee',['actionUpdateEmployee','actionCheckEmail','actionEditEmployee']),
			confirmPassword(){
		      	if(this.form.password && this.form.passwordConfirm){
			      	if(this.form.password != this.form.passwordConfirm){
				        this.checkPassword = true
			      	} else {
				        this.checkPassword = false
			      	}
		      	}
		    },
		    photoImg(img){
		    	if (img) {
					if (img.length < 100) {
						return '/users/'+img;
					}else{
						return img
					}
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
	    		return this.requiredInput && input === '';
		    },
		    async sendEmployee(){
				if (this.form.name && this.form.email && this.form.role_id) {
					await this.actionUpdateEmployee(this.form)
					if (this.getMassage.success) {
						this.$router.push("/crm/employee");
						this.requiredInput =false
						toast.fire({
					    	type: 'success',
					    	icon: 'success',
							title: 'Ползователь изменено!',
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
			}
		},
	}
</script>
<style scoped>
	
</style>
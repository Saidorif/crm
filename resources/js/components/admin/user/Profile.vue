<template>
	<div class="card">
      	<div class="card-header">
            <h3 class="card-title"><i class="far fa-user"></i>USER PROFILE</h3>
      	</div>
      	<form role="form" @submit.prevent.enter="sendProfile">
            <div class="card-body">
              <div class="form-group">
                <label for="fullname">Fullname</label>
                <input 
                	type="text" 
                	class="form-control" 
                	id="fullname" 
                	:class="isRequired(form.fullname) ? 'isRequired' : ''" 
                	placeholder="Fullname"
                	v-model="form.fullname"
            	>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input 
                	type="email" 
                	class="form-control"
                	:class="isRequired(form.email) ? 'isRequired' : ''"  
                	id="exampleInputEmail1" 
                	placeholder="Enter email"
                	v-model="form.email"
            	>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input 
                	type="password" 
                	class="form-control" 
                	id="exampleInputPassword1" 
                	placeholder="Password.."
                	:class="isRequired(form.password) ? 'isRequired' : ''"  
                	v-model="form.password"
            	>
              </div>
              <div class="form-group">
                <label for="ConfirmPassword1">Confirm Password</label>
                <input 
                	type="password" 
                	class="form-control" 
                	id="ConfirmPassword1" 
                	placeholder="Confirm Password.."
                	v-model="form.passwordConfirm"
                	:class="isRequired(form.passwordConfirm) ? 'isRequired' : ''"  
                	@input="confirmPassword()"
            	>
            	<small class="redText" v-if="checkPassword"><b>Пароль не совпадает</b></small>
              </div>
              <div class="d-flex justify-content-end">
	              <button type="submit" class="btn btn-primary">Сохранить</button>
              </div>
            </div>
      	</form>
    </div>
</template>	
<script>
	export default{
		data(){
			return{
				form:{
					fullname:'',
					email:'',
					password:'',
					passwordConfirm:'',
				},
				requiredInput:false,
				checkPassword:false,
			}
		},
		computed:{
		},
		methods:{
	    confirmPassword(){
	      	if(this.form.password && this.form.passwordConfirm){
		      	if(this.form.password != this.form.passwordConfirm){
			        this.checkPassword = true
		      	} else {
			        this.checkPassword = false
		      	}
	      	}
	    },
			isRequired(input){
    		return this.requiredInput && input === '';
	    },
			sendProfile(){
				if (this.form.fullname && this.form.email && this.form.password && this.form.passwordConfirm && this.checkPassword == false) {
					console.log(this.form)
				}else{
					this.requiredInput = true
				}
			}
		}
	}
</script>
<style scoped>
	.redText{
		color:red;
	}
</style>
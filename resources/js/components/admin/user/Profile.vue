<template>
	<div class="card">
  	<div class="card-header">
      <h3 class="card-title title_user mb-0"><i class="peIcon pe-7s-user"></i>User profile</h3>
  	</div>
  	<form role="form" @submit.prevent.enter="sendProfile">
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
          <label for="exampleInputEmail1">Email</label>
          <input 
          	type="email" 
          	class="form-control input_style"
          	:class="isRequired(form.email) ? 'isRequired' : ''"  
          	id="exampleInputEmail1" 
          	placeholder="Enter email"
          	v-model="form.email"
      	>
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
        <div class="col-12 d-flex justify-content-end">
          <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Сохранить</button>
        </div>
      </div>
  	</form>
  </div>
</template>	
<script>
  import { mapActions , mapGetters } from 'vuex'
	export default{
		data(){
			return{
				form:{
					name:'',
					email:'',
					password:'',
					passwordConfirm:'',
				},
				requiredInput:false,
				checkPassword:false,
			}
		},
		computed:{
      ...mapGetters('user',['getProfile'])
		},
    async mounted(){
      await this.ActionProfile()
      this.form = this.getProfile
    },
		methods:{
      ...mapActions('user',['ActionProfile','ActionProfileUpdate']),
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
			async sendProfile(){
				if (this.form.name && this.form.email && this.form.password && this.form.passwordConfirm && this.checkPassword == false) {
            await this.ActionProfileUpdate(this.form)
            toast.fire({
              type: 'success',
              icon: 'success',
              title: 'Данный изменен!',
            })
				}else{
					this.requiredInput = true
				}
			}
		}
	}
</script>
<style scoped>

</style>
<template>
	<div class="card lognCard">
	    <div class="card-body login-card-body">
			<div class="login_alert" v-if="errorMsg"><i class="fas fa-exclamation-circle mr-2"></i> Неверный логин  или пароль </div>
			<div class="form_content pt-4">
				<!-- <div class="login_logo">
					<img src="/logo.png">
				</div> -->
				<p class="login_title"> Вход в персональный кабинет</p>
				<form @submit.enter.prevent="onSubmit">
					<div class="input-group">
						<input type="email" class="form-control" placeholder="Email" v-model="form.email">
						<div class="input-group-append">
							<div class="input-group-text">
								<img src="/img/user.png" alt="">
							</div>
						</div>
					</div>
					<div class="input-group">
						<input type="password" class="form-control" placeholder="Пароль" v-model="form.password">
						<div class="input-group-append">
							<div class="input-group-text">
								<img src="/img/key.png" alt="">
							</div>
						</div>
					</div>
					<div class="row">
						<!-- <div class="col-8">
							<div class="icheck-primary">
								<input type="checkbox" id="remember">
								<label for="remember">
									Remember Me
								</label>
							</div>
						</div> -->
						<!-- /.col -->
						<div class="col-12">
							<button type="submit" class="btn btn-primary btn-block"> {{$t('enter')}}</button>
						</div>
						<!-- /.col -->
					</div>
				</form>
			</div>
	    </div>
  	</div>
</template>
<script>
	import { mapActions, mapGetters } from "vuex";
	import { TokenService } from "./../../services/storage.service";
	export default{
		data() {
		    return {
		      form: {
		        email: "",
		        password: ""
			  },
			  errorMsg: null
		    };
	  	},
	 	computed: {
		    ...mapGetters(["authenticationErrorCode","authenticationError"])
	  	},
	  	async mounted(){
	  		
	  	},
	  	methods: {
		    ...mapActions(["login"]),
		    async onSubmit(){
		      this.$Progress.start();
		      if (this.form.email != "" && this.form.password != "") {
		        await this.login(this.form);
		        await this.authenticationErrorCode;
		        if (!this.authenticationErrorCode){
		          toast.fire({
					type: "success",
					icon: 'success',
		            title: "Вошли в систему!"
		          });
		          this.$Progress.finish();
				 	if (TokenService.getCurrentUser().role.name == 'admin' || TokenService.getCurrentUser().role.name == 'kadr') {
					  	window.location.href = "/crm/dashboard";
		          	}else{
					  	window.location.href = "/crm/profile";
		          	}
		        }else{
					this.errorMsg = this.authenticationError
				  	this.$Progress.fail();

		        }
		      }
		    }
	  	},
	  	beforeRouteEnter(to, from, next){
		    if (TokenService.getToken()){
		      if (TokenService.getCurrentUser().role.name == 'admin' || TokenService.getCurrentUser().role.name == 'kadr') {
		        next(vm=>{
		          vm.$router.push('/crm/dashboard')
		        })
		      }else{
		        next(vm=>{
		          vm.$router.push('/crm/profile')
		        })
		      }
		    }
		    next()
	  	},
	}
</script>
<style scoped>

</style>
<template>
	<div class="card">
	    <div class="card-body login-card-body">
			<div class="form_content">
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
							<button type="submit" class="btn btn-primary btn-block">Войти</button>
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
		    };
	  	},
	 	computed: {
		    ...mapGetters(["authenticationErrorCode"])
	  	},
	  	async mounted() {

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
		            title: "Вошли в систему!"
		          });
		          this.$Progress.finish();
		          this.$router.push("/crm/dashboard");
		        }else{
		          this.$Progress.fail();
		        }
		      }
		    }
	  	},
	}
</script>
<style scoped>
	.card{
		margin-bottom: 0;
		height: 100vh;
		width: 100%;
		border: none;
	}
	.login-card-body{
		background-image: url('/img/loginbg.jpg');
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
		position: relative;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.login-card-body::before{
		content: '';
		position: absolute;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		background-color: rgba(0,0,0,0.8);
		z-index: 0;
	}
	.form_content{
		position: relative;
		z-index: 1;
		background: #FFFFFF;
		box-shadow: 5px 5px 20px rgba(0, 35, 109, 0.05);
		width: 360px;
		padding: 30px;
	}
	.login_title{
		font-style: normal;
		font-weight: 500;
		font-size: 18px;
		line-height: 22px;
		color: #00236D;
		text-align: center;
		margin-bottom: 30px;
	}
	.btn-block{
		background: #00236D;
		border-radius: 100px;
		font-weight: 600;
		font-size: 16px;
		line-height: 22px;
		display: flex;
		align-items: center;
		text-align: center;
		justify-content: center;
		color: #fff;
		border: none;
		height: 46px;
	}
	.form-control{
		background: #FFFFFF;
		border: 1px solid #D4E2F5;
		box-sizing: border-box;
		border-radius: 5px;
		font-style: normal;
		font-weight: 500;
		font-size: 15px;
		line-height: 21px;
		color: #202020;
		height: 40px;
	}
	.login-card-body .input-group .form-control:focus~.input-group-append .input-group-text, .register-card-body .input-group .form-control:focus~.input-group-append .input-group-text,
	.form-control:focus{
		border-color:#00236D;
	}
	.input-group-text{
		border-color: #D4E2F5;
	}
	.input-group{
		margin-bottom: 30px;
	}
</style>
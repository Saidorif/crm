<template>
	<div class="card">
	    <div class="card-body login-card-body">
	      <p class="login-box-msg">Sign in to start your session</p>
	      <form @submit.enter.prevent="onSubmit">
	        <div class="input-group mb-3">
	          <input type="email" class="form-control" placeholder="Email" v-model="form.email">
	          <div class="input-group-append">
	            <div class="input-group-text">
	              <span class="fas fa-envelope"></span>
	            </div>
	          </div>
	        </div>
	        <div class="input-group mb-3">
	          <input type="password" class="form-control" placeholder="Password" v-model="form.password">
	          <div class="input-group-append">
	            <div class="input-group-text">
	              <span class="fas fa-lock"></span>
	            </div>
	          </div>
	        </div>
	        <div class="row">
	          <div class="col-8">
	            <div class="icheck-primary">
	              <input type="checkbox" id="remember">
	              <label for="remember">
	                Remember Me
	              </label>
	            </div>
	          </div>
	          <!-- /.col -->
	          <div class="col-4">
	            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
	          </div>
	          <!-- /.col -->
	        </div>
	      </form>

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
	
</style>
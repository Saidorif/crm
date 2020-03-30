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

    <hr>
    <h3>Change password</h3>
    <form @submit.prevent.enter="changePassword">
      <div class="card-body d-flex flex-wrap">
        <div class="form-group col-md-6">
          <label for="exampleInputPassword1">Password</label>
          <input 
            type="password" 
            class="form-control input_style" 
            id="exampleInputPassword1" 
            placeholder="Password.."
            :class="isRequiredPassword(passwords.password) ? 'isRequired' : ''"  
            v-model="passwords.password"
        >
        </div>
        <div class="form-group col-md-6">
          <label for="ConfirmPassword1">Confirm Password</label>
          <input 
            type="password" 
            class="form-control input_style" 
            id="ConfirmPassword1" 
            placeholder="Confirm Password.."
            v-model="passwords.confirm_password"
            :class="isRequiredPassword(passwords.confirm_password) ? 'isRequired' : ''"  
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
          address:'',
          phone:'',
          image:'',
          file:'',
          text:'',
				},
        passwords:{
					password:'',
					confirm_password:''
        },
				requiredInput:false,
        requiredPassword:false,
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
      ...mapActions('user',['ActionProfile','ActionProfileUpdate','ActionChangePassword']),
	    confirmPassword(){
	      	if(this.passwords.password && this.passwords.confirm_password){
		      	if(this.passwords.password != this.passwords.confirm_password){
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
      isRequiredPassword(input){
        return this.requiredPassword && input === '';
      },
			async sendProfile(){
				if (this.form.name && this.form.email){
            await this.ActionProfileUpdate(this.form)
            toast.fire({
              type: 'success',
              icon: 'success',
              title: 'Данный изменен!',
            })
				}else{
					this.requiredInput = true
				}
			},
      async changePassword(){
        if(this.passwords.password && this.passwords.confirm_password && this.checkPassword == false) 
        {
          await this.ActionChangePassword(this.passwords)
          toast.fire({
            type: 'success',
            icon: 'success',
            title: 'Пароль изменен!',
          })
        }else{
          this.requiredPassword = true
        }
      }
		}
	}
</script>
<style scoped>

</style>
<template>
  <div class="add_employee">
    		<Loader v-if="loading" />
    <div class="card">
      <div class="card-header">
        <h3 class="card-title title_user mb-0">
          <i class="peIcon pe-7s-user"></i>{{ $t('admin_menu.add_employee') }} 
        </h3>
        <router-link class="btn btn-primary back_btn" to="/crm/employee">
          <span class="peIcon pe-7s-back"></span> {{ $t('back') }} 
        </router-link>
      </div>
      <form role="form" @submit.prevent.enter="sendEmployee" enctype="multipart/form-data">
        <div class="card-body d-flex flex-wrap">
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">{{ $t('user_info.fio') }} </label>
              <input
                type="text"
                class="form-control input_style"
                id="name"
                :class="isRequired(form.name) ? 'isRequired' : ''"
                :placeholder="$t('user_info.fio')"
                v-model="form.name"
              />
            </div>
            <div class="form-group" v-if="form.role_id != 3">
              <label for="position">{{$t('user_info.positions')}}</label>
              <input 
                type="text"
                 name="position" 
                 :placeholder="$t('user_info.positions')" 
                 v-model="form.position" 
                 class="form-control"
                 :class="isRequired(form.position) ? 'isRequired' : '' "
                 id="position"
               >
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">{{$t('user_info.email')}}</label>
              <input
                type="email"
                class="form-control input_style"
                :class="isRequired(form.email) ? 'isRequired' : ''"
                id="exampleInputEmail1"
                :placeholder="$t('user_info.email')"
                v-model="form.email"
                @blur="checkEmailInput"
              />
              <small class="redText" v-if="emailError">Email почта занят!</small>
            </div>
            <div class="input_block_d_flex">
              <div class="form-group col-md-6">
                <label for="role">{{$t('user_info.role')}}</label>
                <select
                  class="form-control"
                  :class="isRequired(form.role_id) ? 'isRequired' : '' "
                  id="countryName"
                  v-model="form.role_id"
                >
                  <option value selected disabled>{{$t('user_info.select_role')}}</option>
                  <option :value="role.id" v-for="(role,index) in getRoleList">{{role.name}}</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="birthday">{{$t('user_info.status.title')}}</label>
                <select v-model="form.status" class="form-control">
                  <option value="active" selected>{{$t('user_info.status.active')}}</option>
                  <option value="inactive">{{$t('user_info.status.inactive')}}</option>
                </select>
              </div>
            </div>
            <div class="input_block_d_flex">
              <div class="form-group col-md-6">
                <label for="exampleInputPassword1">{{$t('user_info.password')}}</label>
                <input
                  type="password"
                  class="form-control input_style"
                  id="exampleInputPassword1"
                  :placeholder="$t('user_info.password')"
                  :class="isRequired(form.password) ? 'isRequired' : ''"
                  v-model="form.password"
                />
              </div>
              <div class="form-group col-md-6">
                <label for="ConfirmPassword1">{{$t('user_info.confirm_password')}}</label>
                <input
                  type="password"
                  class="form-control input_style"
                  id="ConfirmPassword1"
                  :placeholder="$t('user_info.confirm_password')"
                  v-model="form.confirm_password"
                  :class="isRequired(form.confirm_password) ? 'isRequired' : ''"
                  @input="confirmPassword()"
                />
                <small class="redText" v-if="checkPassword">
                  <b>{{$t('user_info.password_dnmatch')}}</b>
                </small>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group photoFileUploader">
              <!-- userImg -->
              <div class="avatar-upload">
                <div class="avatar-edit">
                  <input
                    type="file"
                    id="image"
                    accept=".png, .jpg, .jpeg"
                    @change="changePhoto($event)"
                  />
                  <label for="image">
                    <i class="pe-7s-pen"></i>
                  </label>
                </div>
                <div class="avatar-preview">
                  <div
                    id="imagePreview"
                    :style="{'backgroundImage': 'url('+ photoImg(form.image) +')'}"
                  ></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> {{$t('save')}}
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import DatePicker from "vue2-datepicker";
import { mapActions, mapGetters } from "vuex";
import Loader from '../../Loader'
export default {
  components: {
    DatePicker,
    Loader
  },
  data() {
    return {
      form: {
        name: "",
        email: "",
        password: "",
        confirm_password: "",
        role_id: "",
        position: "",
        image: "",
        status: "active",
      },
      fileFormat: "нет-файла",
      requiredInput: false,
      checkPassword: false,
      emailError: false,
      loading: true,
    };
  },
  async mounted() {
    await this.actionRoleList();
    await this.actionCategoryList();
    // await this.actionPositionList();
    this.loading = false
  },
  computed: {
    ...mapGetters("employee", ["getMassage"]),
    ...mapGetters("role", ["getRoleList"]),
    ...mapGetters("category", ["getCategories"]),
    // ...mapGetters("position", ["getPositionList"])
  },
  methods: {
    ...mapActions("category", ["actionCategoryList"]),
    ...mapActions("role", ["actionRoleList"]),
    ...mapActions("employee", ["actionAddEmployee", "actionCheckEmail"]),
    // ...mapActions("position", ["actionPositionList"]),
    confirmPassword() {
      if (this.form.password && this.form.confirm_password) {
        if (this.form.password != this.form.confirm_password) {
          this.checkPassword = true;
        } else {
          this.checkPassword = false;
        }
      }
    },
    photoImg(img) {
      if (img.length < 100) {
        return "/img/user.jpg";
      } else {
        return img;
      }
    },
    changePhoto(event) {
      let file = event.target.files[0];
      if (
        event.target.files[0]["type"] === "image/png" ||
        event.target.files[0]["type"] === "image/jpeg" ||
        event.target.files[0]["type"] === "image/jpg"
      ) {
        if (file.size > 1048576) {
          swal.fire({
            type: "error",
            title: "Ошибка",
            text: "Размер изображения больше лимита"
          });
        } else {
          let reader = new FileReader();
          reader.onload = event => {
            this.form.image = event.target.result;
          };
          reader.readAsDataURL(file);
        }
      } else {
        swal.fire({
          type: "error",
          title: "Ошибка",
          text: "Картинка должна быть только png,jpg,jpeg!"
        });
      }
    },
    isRequired(input) {
      if (input != null) {
        return this.requiredInput && input === "";
      }
    },
    async sendEmployee() {
      if (
        this.form.name &&
        this.form.email &&
        this.form.password &&
        this.form.confirm_password &&
        this.form.role_id &&
        this.form.position &&
        this.checkPassword == false
      ) {
        await this.actionAddEmployee(this.form);
        if (this.getMassage.success) {
          this.$router.push("/crm/employee");
          this.requiredInput = false;
          toast.fire({
            type: "success",
            icon: "success",
            title: "Ползователь добавлено!"
          });
        }
      } else {
        this.requiredInput = true;
      }
    },
    async checkEmailInput() {
      await this.actionCheckEmail({ email: this.form.email });
      if (
        this.getMassage.error &&
        this.getMassage.message.email == "Почта уже занята."
      ) {
        this.emailError = true;
      } else {
        this.emailError = false;
      }
    },
  }
};
</script>
<style scoped>
</style>
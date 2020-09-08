<template>
  <div class="add_employee">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title title_user mb-0">
          <i class="peIcon pe-7s-user"></i>Редактировать пользователя
        </h3>
        <router-link class="btn btn-primary back_btn" to="/crm/employee">
          <span class="peIcon pe-7s-back"></span> Назад
        </router-link>
      </div>
      <form role="form" @submit.prevent.enter="sendEmployee" enctype="multipart/form-data">
        <div class="card-body d-flex flex-wrap">
          <div class="col-md-6">
            <div class="form-group">
              <label for="name">Ф.И.О</label>
              <input
                type="text"
                class="form-control input_style"
                id="name"
                :class="isRequired(form.name) ? 'isRequired' : ''"
                placeholder="Ф.И.О"
                v-model="form.name"
              />
            </div>
            <div class="form-group" v-if="form.role_id != 3">
              <label for="position">Должность</label>
              <input 
                type="text"
                 name="position" 
                 placeholder="Должность..." 
                 v-model="form.position" 
                 class="form-control"
                 :class="isRequired(form.position) ? 'isRequired' : '' "
                 id="position"
               >
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">E-mail</label>
              <input
                type="email"
                class="form-control input_style"
                :class="isRequired(form.email) ? 'isRequired' : ''"
                id="exampleInputEmail1"
                placeholder="E-mail"
                v-model="form.email"
                @blur="checkEmailInput"
              />
              <small class="redText" v-if="emailError">Email почта занят!</small>
            </div>
            <div class="input_block_d_flex">
              <div class="form-group col-md-6">
                <label for="role">Рол</label>
                <select
                  class="form-control"
                  :class="isRequired(form.role_id) ? 'isRequired' : '' "
                  id="countryName"
                  v-model="form.role_id"
                >
                  <option value selected disabled>Выберите рол</option>
                  <option :value="role.id" v-for="(role,index) in getRoleList">{{role.name}}</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="birthday">Статус</label>
                <select v-model="form.status" class="form-control">
                  <option value="active" selected>Активный</option>
                  <option value="inactive">Неактивный</option>
                </select>
              </div>
            </div>
            <div class="input_block_d_flex">
              <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Пароль</label>
                <input
                  type="password"
                  class="form-control input_style"
                  id="exampleInputPassword1"
                  placeholder="Пароль.."
                  :class="isRequired(form.password) ? 'isRequired' : ''"
                  v-model="form.password"
                />
              </div>
              <div class="form-group col-md-6">
                <label for="ConfirmPassword1">Подтвердите пароль</label>
                <input
                  type="password"
                  class="form-control input_style"
                  id="ConfirmPassword1"
                  placeholder="Подтвердите пароль.."
                  v-model="form.confirm_password"
                  :class="isRequired(form.confirm_password) ? 'isRequired' : ''"
                  @input="confirmPassword()"
                />
                <small class="redText" v-if="checkPassword">
                  <b>Пароль не совпадает</b>
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
              <i class="fas fa-save"></i> Сохранить
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
export default {
  components: {
    DatePicker
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
      emailError: false
    };
  },
  async mounted() {
    await this.actionRoleList();
    await this.actionCategoryList();
    // await this.actionPositionList();
    await this.actionEditEmployee({ id: this.$route.params.employeeId });
    this.form = this.getEmployee;
  },
  computed: {
    ...mapGetters("employee", ["getMassage", "getEmployee"]),
    ...mapGetters("role", ["getRoleList"]),
    ...mapGetters("category", ["getCategories"]),
    // ...mapGetters("position", ["getPositionList"])
  },
  methods: {
    ...mapActions("category", ["actionCategoryList"]),
    ...mapActions("role", ["actionRoleList"]),
    ...mapActions("employee", [
      "actionUpdateEmployee",
      "actionCheckEmail",
      "actionEditEmployee"
    ]),
    // ...mapActions("position", ["actionPositionList"]),
    confirmPassword() {
      if (this.form.password && this.form.passwordConfirm) {
        if (this.form.password != this.form.passwordConfirm) {
          this.checkPassword = true;
        } else {
          this.checkPassword = false;
        }
      }
    },
    photoImg(img) {
      if(img != null){
        if (img.length < 100) {
          return "/img/user.jpg";
        } else {
          return img;
        }
      }else{
        return "/img/user.jpg";
      }

    },
    changeFile(event) {
      let file = event.target.files[0];
      if (file.size > 1048576) {
        swal.fire({
          type: "error",
          icon: "error",
          title: "Ошибка",
          text: "Размер файл не должно быть больше 1мб"
        });
      } else {
        let reader = new FileReader();
        reader.onload = e => {
          this.form.file = e.target.result;
          this.fileFormat = event.target.files[0].name.substr(event.target.files[0].name.lastIndexOf("\\") + 1).split(".")[1];
        };
        reader.readAsDataURL(file);
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
      return this.requiredInput && input === "";
    },
    async sendEmployee(){
      if (this.form.name && this.form.email && this.form.role_id && this.form.position) {
        await this.actionUpdateEmployee(this.form);
        if (this.getMassage.success) {
          this.$router.push("/crm/employee");
          this.requiredInput = false;
          toast.fire({
            type: "success",
            icon: "success",
            title: "Ползователь изменено!"
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
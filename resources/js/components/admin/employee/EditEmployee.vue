<template>
  <div class="edit_employee">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title title_user mb-0">
          <i class="peIcon pe-7s-user"></i>Редактировать
        </h3>
        <router-link class="btn btn-primary back_btn" to="/crm/employee"><span class="peIcon pe-7s-back"></span> Назад</router-link>
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
              <select
                class="form-control"
                :class="isRequired(form.position_id) ? 'isRequired' : '' "
                id="position"
                v-model="form.position_id"
              >
                <option value selected disabled>Выберите должность</option>
                <option
                  :value="position.id"
                  v-for="(position,index) in getPositionList"
                >{{position.name}}</option>
              </select>
            </div>
            <div class="form-group">
              <label for="role">Role</label>
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
            <div class="form-group">
              <label for="exampleInputEmail1">Email</label>
              <input
                type="email"
                class="form-control input_style"
                :class="isRequired(form.email) ? 'isRequired' : ''"
                id="exampleInputEmail1"
                placeholder="Enter email"
                v-model="form.email"
                @blur="checkEmailInput"
              />
              <small class="redText" v-if="emailError">Email почта занят!</small>
            </div>
            <div class="form-group">
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
            <div class="form-group">
              <label for="ConfirmPassword1">Подтвердите пароль</label>
              <input
                type="password"
                class="form-control input_style"
                id="ConfirmPassword1"
                placeholder="Подтвердите пароль.."
                v-model="form.passwordConfirm"
                :class="isRequired(form.passwordConfirm) ? 'isRequired' : ''"
                @input="confirmPassword()"
              />
              <small class="redText" v-if="checkPassword">
                <b>Пароль не совпадает</b>
              </small>
            </div>
            <div class="form-group">
              <label for="fortext">Текст</label>
              <textarea
                class="form-control input_style"
                v-model="form.text"
                placeholder="Текст.."
                style="height: 114px; resize: none;"
              ></textarea>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group photoFileUploader">
              <div class="avatar-upload">
                <div class="avatar-edit">
                  <input type="file" id="file" @change="changeFile($event)" />
                  <label for="file">
                    <i class="pe-7s-pen"></i>
                  </label>
                </div>
                <div class="avatar-preview">
                  <div id="fileimagePreview">
                    <span>{{fileFormat}}</span>
                  </div>
                </div>
              </div>
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
            <div class="form-group" v-if="form.role_id != 3">
              <label for="category">Управления</label>
              <select class="form-control" id="category" v-model="form.category_id">
                <option value selected disabled>Выберите управление</option>
                <option
                  :value="category.id"
                  v-for="(category,index) in getCategories"
                >{{category.name}}</option>
              </select>
            </div>
            <div class="form-group">
              <label for="birthday">Дата рождения</label>
              <date-picker
                lang="ru"
                v-model="form.birthday"
                valuetype="format"
                format="YYYY-MM-DD"
                placeholder="YYYY-MM-DD"
              ></date-picker>
            </div>
            <div class="form-group">
              <label for="address">Адрес</label>
              <input
                type="text"
                class="form-control input_style"
                id="address"
                placeholder="Адрес.."
                v-model="form.address"
              />
            </div>
            <div class="input_block_d_flex" v-if="form.role_id != 3">
              <div class="form-group col-md-6">
                <label for="date_from">Дата с</label>
                <date-picker
                  lang="ru"
                  v-model="form.order_date"
                  valuetype="format"
                  format="YYYY-MM-DD"
                  placeholder="YYYY-MM-DD"
                ></date-picker>
              </div>
              <div class="form-group col-md-6">
                <label for="date_to">Дата по</label>
                <date-picker
                  lang="ru"
                  v-model="form.leave_date"
                  valuetype="format"
                  format="YYYY-MM-DD"
                  placeholder="YYYY-MM-DD"
                  :disabled="form.working"
                ></date-picker>
                <div class="input_radio">
                  <label for="working">до настоящего времени</label>
                  <input
                    type="checkbox"
                    class="input_switch"
                    name="working"
                    v-model="form.working"
                    id="working"
                  />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="phone">Телефон</label>
              <input
                type="text"
                class="form-control input_style"
                id="phone"
                placeholder="Phone.."
                v-model="form.phone"
              />
            </div>
          </div>

          <h5 class="sub_title">Трудовая деятельность</h5>
          <div class="row col-md-12" v-for="(ex, index) in form.experience">
            <div class="col-12 d-flex justify-content-end">
              <button
                type="button"
                class="btn btn-primary mr-3"
                @click="removeExperience(ex, index)"
              >
                <i class="fas fa-plus"></i> удалить опыт
              </button>
            </div>
            <div class="form-group col-md-3">
              <label for="company">Название учреждения</label>
              <input
                type="text"
                class="form-control input_style"
                id="company"
                :class="isRequired(ex.company) ? 'isRequired' : ''"
                placeholder="Название учреждения"
                v-model="ex.company"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="position">Должность</label>
              <input
                type="text"
                class="form-control input_style"
                id="position"
                :class="isRequired(ex.position) ? 'isRequired' : ''"
                placeholder="Должность"
                v-model="ex.position"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="date_from">Дата с</label>
              <input
                type="date"
                class="form-control input_style"
                id="date_from"
                :class="isRequired(ex.date_from) ? 'isRequired' : ''"
                placeholder="date_from"
                v-model="ex.date_from"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="date_to">Дата по</label>
              <input
                type="date"
                class="form-control input_style"
                id="date_to"
                :class="isRequired(ex.date_to) ? 'isRequired' : ''"
                placeholder="date_to"
                v-model="ex.date_to"
              />
            </div>
            <div class="form-group col-md-6">
              <label for="address">>Адрес учреждения</label>
              <input
                type="text"
                class="form-control input_style"
                id="address"
                placeholder=">Адрес учреждения"
                v-model="ex.address"
              />
            </div>
            <div class="form-group col-md-6">
              <label for="description">Описание</label>
              <input
                type="text"
                class="form-control input_style"
                id="description"
                placeholder="Описание"
                v-model="ex.description"
              />
            </div>
            <hr />
          </div>
          <div class="col-12 d-flex justify-content-end">
            <button type="button" class="btn btn-primary mr-3" @click="addExperience()">
              <i class="fas fa-plus"></i> Добавить опыт
            </button>
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
        id: "",
        name: "",
        email: "",
        password: "",
        passwordConfirm: "",
        category_id: "",
        address: "",
        role_id: "",
        position_id: "",
        phone: "",
        image: "",
        file: "",
        text: "",
        order_date: "",
        birthday: "",
        leave_date: "",
        working: false,
        experience: []
      },
      requiredInput: false,
      checkPassword: false,
      emailError: false,
      fileFormat: "нет-файла"
    };
  },
  async mounted() {
    await this.actionRoleList();
    await this.actionCategoryList();
    await this.actionPositionList();
    await this.actionEditEmployee({ id: this.$route.params.employeeId });
    this.form = this.getEmployee;
  },
  computed: {
    ...mapGetters("employee", ["getMassage", "getEmployee"]),
    ...mapGetters("role", ["getRoleList"]),
    ...mapGetters("category", ["getCategories"]),
    ...mapGetters("position", ["getPositionList"])
  },
  methods: {
    ...mapActions("category", ["actionCategoryList"]),
    ...mapActions("role", ["actionRoleList"]),
    ...mapActions("employee", [
      "actionUpdateEmployee",
      "actionCheckEmail",
      "actionEditEmployee"
    ]),
    ...mapActions("position", ["actionPositionList"]),
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
      console.log(img)
      if(img){
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
          this.fileFormat = event.target.files[0].name
            .substr(event.target.files[0].name.lastIndexOf("\\") + 1)
            .split(".")[0];
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
    async sendEmployee() {
      if (this.form.name && this.form.email && this.form.role_id) {
        if (this.form.experience.length) {
          await this.actionUpdateEmployee(this.form);
        } else {
          delete this.form.experience;
          await this.actionUpdateEmployee(this.form);
        }
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
    addExperience() {
      let item = {
        company: "",
        date_from: "",
        date_to: "",
        address: "",
        position: "",
        description: ""
      };
      this.form.experience.push(item);
    },
    removeExperience(ex, index) {
      this.form.experience.splice(index, 1);
    }
  }
};
</script>
<style scoped>
</style>
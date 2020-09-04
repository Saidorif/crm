<template>
  <div class="add_employee">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title title_user mb-0">
          <i class="peIcon pe-7s-user"></i>Добавить пользователя
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
                 v-model="position" 
                 class="form-control"
                 :class="isRequired(form.position) ? 'isRequired' : '' "
                 id="position"
               >
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
            <div class="form-group">
              <label for="address">Адрес</label>
              <input
                type="text"
                class="form-control input_style"
                id="address"
                placeholder="Адрес.."
                v-model="form.address"
                :class="isRequired(form.address) ? 'isRequired' : ''"
              />
            </div>
            <div class="input_block_d_flex">
              <div class="form-group col-md-6">
                <label for="nation">Нация</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="nation"
                  placeholder="Нация.."
                  :class="isRequired(form.nation) ? 'isRequired' : ''"
                  v-model="form.nation"
                />
              </div>
              <div class="form-group col-md-6">
                <label for="education">Образование</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="education"
                  placeholder="Образование"
                  v-model="form.education"
                  :class="isRequired(form.education) ? 'isRequired' : ''"
                />
              </div>
            </div>
            <div class="input_block_d_flex">
              <div class="form-group col-md-6">
                <label for="languages">Знает ли иностранные языки</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="languages"
                  placeholder="Знает ли иностранные языки.."
                  :class="isRequired(form.languages) ? 'isRequired' : ''"
                  v-model="form.languages"
                />
              </div>
              <div class="form-group col-md-6">
                <label for="state_award">Получал ли государственные награды</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="state_award"
                  placeholder="Получал ли государственные награды"
                  v-model="form.state_award"
                  :class="isRequired(form.state_award) ? 'isRequired' : ''"
                />
              </div>
            </div>
            <div class="form-group">
              <label for="fortext">Образование (название,профессия,адрес)</label>
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
            <div class="input_block_d_flex">
              <div class="form-group col-md-6">
                <label for="birthday">Дата рождения</label>
                <date-picker
                  lang="ru"
                  v-model="form.birthday"
                  valuetype="format"
                  format="YYYY-MM-DD"
                  placeholder="YYYY-MM-DD"
                ></date-picker>
              </div>
              <div class="form-group col-md-6">
                <label for="birthday">Статус</label>
                <select v-model="form.status" class="form-control">
                  <option value="active" selected>Активный</option>
                  <option value="inactive">Неактивный</option>
                </select>
              </div>
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
            <div class="input_block_d_flex">
              <div class="form-group col-md-6">
                <label for="phone">Телефон</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="Телефон"
                  placeholder="Phone.."
                  v-model="form.phone"
                  :class="isRequired(form.phone) ? 'isRequired' : ''"
                />
              </div>
              <div class="form-group col-md-6" v-if="form.role_id != 3">
                <label for="gender">Пол</label>
                <select
                  class="form-control"
                  id="gender"
                  v-model="form.gender"
                  :class="isRequired(form.gender) ? 'isRequired' : ''"
                >
                  <option value selected disabled>Выберите пол</option>
                  <option value="male">Мужчина</option>
                  <option value="female">Женщина</option>
                </select>
              </div>
            </div>
            <div class="input_block_d_flex">
              <div class="form-group col-md-6">
                <label for="partisanship">Партийность:</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="partisanship"
                  placeholder="Партийность:"
                  v-model="form.partisanship"
                  :class="isRequired(form.partisanship) ? 'isRequired' : ''"
                />
              </div>
              <div class="form-group col-md-6" v-if="form.role_id != 3">
                <label for="education_spec">По специальности:</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="education_spec"
                  placeholder="По специальности:"
                  v-model="form.education_spec"
                  :class="isRequired(form.education_spec) ? 'isRequired' : ''"
                />
              </div>
            </div>
            <div class="input_block_d_flex">
              <div class="form-group col-md-6">
                <label for="partiya">Ученое звание:</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="partiya"
                  placeholder="Ученое звание:"
                  v-model="form.academic_degree"
                  :class="isRequired(form.academic_degree) ? 'isRequired' : ''"
                />
              </div>
              <div class="form-group col-md-6" v-if="form.role_id != 3">
                <label for="academic_sertificate">Ученая Степень:</label>
                <input
                  type="text"
                  class="form-control input_style"
                  id="academic_sertificate"
                  placeholder="Ученая степень:"
                  v-model="form.academic_sertificate"
                  :class="isRequired(form.academic_sertificate) ? 'isRequired' : ''"
                />
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <label for="deputat">Член Совета народных депутатов республики, области, города, района или член других выборных органов (указать полностью)</label>
            <input
              type="text"
              class="form-control input_style"
              id="deputat"
              placeholder="Член Совета народных депутатов республики, области, города, района или член других выборных органов (указать полностью)"
              v-model="form.deputat"
              :class="isRequired(form.deputat) ? 'isRequired' : ''"
            />
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
                placeholder="Название учреждения"
                v-model="ex.company"
                :class="isRequired(ex.company) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="position">Должность</label>
              <input
                type="text"
                class="form-control input_style"
                id="position"
                placeholder="Должность"
                v-model="ex.position"
                :class="isRequired(ex.position) ? 'isRequired' : ''"
              />
            </div>
            <div class="form-group col-md-3">
              <label for="date_from">Дата с</label>
              <date-picker
                lang="ru"
                v-model="ex.date_from"
                valuetype="format"
                placeholder="YYYY-MM-DD"
                format="YYYY-MM-DD"
                :class="isRequired(ex.date_from) ? 'isRequired' : ''"
              ></date-picker>
            </div>
            <div class="form-group col-md-3">
              <label for="date_to">Дата по</label>
              <date-picker
                lang="ru"
                v-model="ex.date_to"
                valuetype="format"
                placeholder="YYYY-MM-DD"
                format="YYYY-MM-DD"
                :class="isRequired(ex.date_to) ? 'isRequired' : ''"
              ></date-picker>
            </div>
            <div class="form-group col-md-6">
              <label for="address">Адрес учреждения</label>
              <input
                type="text"
                class="form-control input_style"
                id="address"
                placeholder="Адрес учреждения"
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
        name: "",
        email: "",
        password: "",
        confirm_password: "",
        category_id: "",
        address: "",
        role_id: "",
        position: "",
        phone: "",
        image: "",
        file: "",
        text: "",
        birthday: "",
        order_date: "",
        leave_date: "",
        status: "active",
        gender: "",
        working: false,
        experience: []
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
        this.form.gender &&
        this.checkPassword == false
      ) {
        if (this.form.experience && this.form.experience.length) {
          await this.actionAddEmployee(this.form);
        } else {
          delete this.form.experience;
          await this.actionAddEmployee(this.form);
        }
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
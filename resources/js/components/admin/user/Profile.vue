<template>
  <div class="card">
    		<Loader v-if="loading" />
    <div class="card-header">
      <h3 class="card-title title_user mb-0">
        <i class="peIcon pe-7s-user"></i>
        {{ $t('admin_menu.my_info') }}
      </h3>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a
          class="nav-link active"
          id="home-tab"
          data-toggle="tab"
          href="#home"
          role="tab"
          aria-controls="home"
          aria-selected="true"
        >
          <i class="peIcon pe-7s-config"></i>{{ $t('user_info.user_settings') }}
        </a>
      </li>
      <li class="nav-item">
        <a
          class="nav-link"
          id="profile-tab"
          data-toggle="tab"
          href="#profile"
          role="tab"
          aria-controls="profile"
          aria-selected="false"
        >
          <i class="peIcon pe-7s-unlock"></i> {{ $t('user_info.change_pass') }}
        </a>
      </li>
<!--       <li class="nav-item">
        <a
          class="nav-link"
          id="contact-tab"
          data-toggle="tab"
          href="#contact"
          role="tab"
          aria-controls="contact"
          aria-selected="false"
        >
          <i class="peIcon pe-7s-user"></i> Резюме
        </a>
      </li> -->
    </ul>
    <div class="tab-content" id="myTabContent" v-if="form.user">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <form role="form" @submit.prevent.enter="sendProfile">
          <div class="card-body d-flex flex-wrap" v-if="form.user">
            <div class="col-md-8">
              <div class="form-group col-md-12">
                <label for="name">{{ $t('user_info.fio') }}</label>
                <p class="form-control input_style disabled">{{form.user.name}}</p>
              </div>
              <div class="form-group col-md-12">
                <label for="name">{{ $t('user_info.email') }}</label>
                <p class="form-control input_style disabled">{{ form.user.email }}</p>
              </div>
              <div class="form-group col-md-12">
                <label for="name">{{ $t('admin_menu.position') }}</label>
                <p
                  class="form-control input_style disabled"
                >{{ form.position }}</p>
              </div>
              <div class="form-group col-md-12">
                <label for="name">{{ $t('user_info.status.title') }}</label>
                <p
                  class="form-control input_style disabled"
                >{{ form.user.status == 'active' ? $t('user_info.status.active') : $t('user_info.status.inactive') }}</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group photoFileUploader" style="margin-bottom: 18px;">
                <div class="avatar-upload">
                  <div class="avatar-edit">
                    <input
                      type="file"
                      id="image"
                      accept=".png, .jpg, .jpeg"
                      @change="changePhoto($event)"
                    />
                   <!--  <label for="image">
                      <i class="pe-7s-pen"></i>
                    </label> -->
                  </div>
                  <div class="avatar-preview">
                    <div
                      id="imagePreview"
                      :style="{'backgroundImage': 'url('+photoImg(form.user.image)+')'}"
                    ></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <form @submit.prevent.enter="changePassword">
          <div class="card-body d-flex flex-wrap">
            <div class="form-group col-md-6">
              <label for="exampleInputPassword1">{{$t('user_info.password')}}</label>
              <input
                type="password"
                class="form-control input_style"
                id="exampleInputPassword1"
                :placeholder="$t('user_info.password')"
                :class="isRequiredPassword(passwords.password) ? 'isRequired' : ''"
                v-model="passwords.password"
              />
            </div>
            <div class="form-group col-md-6">
              <label for="ConfirmPassword1">{{$t('user_info.confirm_password')}}</label>
              <input
                type="password"
                class="form-control input_style"
                id="ConfirmPassword1"
                :placeholder="$t('user_info.confirm_password')"
                v-model="passwords.confirm_password"
                :class="isRequiredPassword(passwords.confirm_password) ? 'isRequired' : ''"
                @input="confirmPassword()"
              />
              <small class="redText" v-if="checkPassword">
                <b>{{$t('user_info.password_dnmatch')}}</b>
              </small>
            </div>
            <div class="col-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> {{$t('save')}}
              </button>
            </div>
          </div>
        </form>
      </div>
      <!-- <div class="tab-pane fade cv_tab" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <button class="print_cv" @click="printCv()">print Cv</button>
        <div size="A4" class="cv_block">
          <h4 class="cv_title">Резюме </h4>
          <div class="cv_header">
            <div class="cv_user_img">
              <img :src="photoImg(form.user.image)" :alt="form.user.title" class="cv_user_img" />
            </div>
            <div class="cv_header_info">
              <h2>{{ form.user.name }}</h2>
              <p>{{ form.user.address }}</p>
              <p>
                <b>Тел:</b>
                <span style="margin-right: 30px;">{{ form.user.phone }}</span>
                <b>Email</b>
                {{ form.user.email }}
              </p>
            </div>
          </div>
          <ul class="cv_body_list">
            <li>
              <b>Год рождения:</b>
              <span>{{ form.user.birthday }}</span>
            </li>
            <li>
              <b>Место рождения:</b>
              <span>{{ form.user.address }}</span>
            </li>
            <li>
              <b>Национальность:</b>
              <span>{{ form.user.nation }}</span>
            </li>
            <li>
              <b>Партийность:</b>
              <span>{{ form.user.partisanship }}</span>
            </li>
            <li>
              <b>Образование:</b>
              <span>{{ form.user.education }}</span>
            </li>
            <li>
              <b>Место учебы:</b>
              <span>{{ form.user.text }}</span>
            </li>
            <li>
              <b>По специальности:</b>
              <span>{{form.user.education_spec}}</span>
            </li>
            <li>
              <b>Ученая степень:</b>
              <span>{{ form.user.academic_degree }}</span>
            </li>
            <li>
              <b>Ученое звание:</b>
              <span>{{ form.user.academic_sertificate }}</span>
            </li>
            <li>
              <b>знает ли иностранные языки ( какие, сертификат или диплом):</b>
              <span>{{ form.user.languages }}</span>
            </li>
            <li>
              <b>Получал ли государственные награды (Какие):</b>
              <span>{{ form.user.state_award }}</span>
            </li>
            <li>
              <b>Член Совета народных депутатов республики, области, города, района или член других выборных органов (указать полностью)</b>
              <span>{{ form.user.deputat }}</span>
            </li>
          </ul>
          <h6 class="cv_exper_subtitle">ТРУДОВАЯ ДЕЯТЕЛЬНОСТЬ</h6>
          <ul class="cv_experience_list">
            <li v-for="(ex, index) in form.user.experience">
              <div class="cv_ex_date">
                <b>{{ex.date_from}}</b> -
                <b>{{ex.date_to}}</b>
              </div>
              <div class="cv_ex_info">
                <p>{{ ex.company}} {{ex.address}} {{ex.description}}</p>
                <p>-{{ex.position}}</p>
              </div>
            </li>
          </ul>
        </div>
      </div> -->
    </div>
  </div>
</template>	
<script>
import { mapActions, mapGetters } from "vuex";
import Loader from '../../Loader'
export default {
  components:{
		Loader
	},
  data() {
    return {
      form: {
        name: "",
        email: "",
        address: "",
        phone: "",
        image: "/img/user.jpg",
        file: "",
        text: ""
      },
      fileFormat: "нет-файла",
      passwords: {
        password: "",
        confirm_password: ""
      },
      requiredInput: false,
      requiredPassword: false,
      checkPassword: false,
      loading: true,
    };
  },
  computed: {
    ...mapGetters("user", ["getProfile"])
  },
  async mounted() {
    await this.ActionProfile();
    this.form = this.getProfile;
    this.loading = false
    console.log(this.form);
  },
  methods: {
    ...mapActions("user", [
      "ActionProfile",
      "ActionProfileUpdate",
      "ActionChangePassword"
    ]),
    confirmPassword() {
      if (this.passwords.password && this.passwords.confirm_password) {
        if (this.passwords.password != this.passwords.confirm_password) {
          this.checkPassword = true;
        } else {
          this.checkPassword = false;
        }
      }
    },
    photoImg(img) {
      if(img != null){
        if (img.length < 100) {
          return "/users/"+img;
        }else{
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
        reader.onload = event => {
          this.form.file = event.target.result;
          this.fileFormat = "docx";
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
            this.form.user.image = event.target.result;
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
    isRequiredPassword(input) {
      return this.requiredPassword && input === "";
    },
    async sendProfile() {
      if (this.form.user.name && this.form.user.email) {
        await this.ActionProfileUpdate(this.form.user);
        toast.fire({
          type: "success",
          icon: "success",
          title: "Данный изменен!"
        });
      } else {
        this.requiredInput = true;
      }
    },
    async changePassword() {
      if (
        this.passwords.password &&
        this.passwords.confirm_password &&
        this.checkPassword == false
      ) {
        await this.ActionChangePassword(this.passwords);
        toast.fire({
          type: "success",
          icon: "success",
          title: "Пароль изменен!"
        });
      } else {
        this.requiredPassword = true;
      }
    },
    printCv() {
      $(".cv_block").printThis();
    }
  }
};
</script>
<style scoped>
.cv_tab {
  background: #9fc1cc40;
  padding: 30px 0px;
}
.cv_block {
  background: white;
  display: block;
  margin: 0px auto;
  margin-bottom: 0.5cm;
}
.cv_block[size="A4"] {
  width: 21cm;
  height: 29.7cm;
  padding: 30px;
}
.cv_block[size="A4"][layout="landscape"] {
  width: 29.7cm;
  height: 21cm;
}
.cv_title {
  text-align: center;
  font-weight: bold;
}
.cv_user_img {
  width: 130px;
  height: 150px;
  overflow: hidden;
  border: 1px solid #000;
  margin-right: 30px;
  margin-bottom: 30px;
}
.cv_user_img img {
  width: 100%;
}
.cv_header {
  display: flex;
  align-items: flex-start;
}
.cv_header_info {
  width: calc(100% - 150px);
}
.cv_header_info h2 {
  font-weight: bold;
}
.cv_block p {
  font-size: 16px;
}
.cv_header_info p {
  margin-bottom: 0;
}
.cv_body_list {
  display: flex;
  flex-wrap: wrap;
}
.cv_body_list li {
  list-style: none;
  width: 60%;
  margin-bottom: 10px;
}
.cv_body_list li:nth-child(odd) {
  width: 40%;
}
.cv_body_list li {
  display: flex;
  flex-direction: column;
}
.cv_body_list li:last-child {
  width: 100%;
}
.cv_exper_subtitle {
  text-align: center;
  font-weight: bold;
}
.cv_experience_list {
}
.cv_experience_list li {
  list-style: none;
  display: flex;
  justify-content: space-between;
}
.cv_ex_date {
  width: 220px;
}
.cv_experience_list li .cv_ex_info {
  width: calc(100% - 220px);
}
.cv_experience_list li .cv_ex_info p {
  margin-bottom: 0;
}
.print_cv {
  position: absolute;
  right: 0;
  top: 120px;
  background: #3f6ad8;
  color: #fff;
  padding: 10px 30px;
  border: none;
}
@media print {
  page {
    background: white;
    display: block;
    margin: 0px auto;
    margin-bottom: 0.5cm;
  }
  page[size="A4"] {
    width: 21cm;
    height: 29.7cm;
    padding: 30px;
  }
  page[size="A4"][layout="landscape"] {
    width: 29.7cm;
    height: 21cm;
  }
  .cv_title {
    text-align: center;
    font-weight: bold;
  }
  .cv_user_img {
    width: 130px;
    height: 150px;
    overflow: hidden;
    border: 1px solid #000;
    margin-right: 30px;
    margin-bottom: 30px;
  }
  .cv_user_img img {
    width: 100%;
  }
  .cv_header {
    display: flex;
    align-items: flex-start;
  }
  .cv_header_info {
    width: calc(100% - 150px);
  }
  .cv_header_info h2 {
    font-weight: bold;
  }
  .cv_block p {
    font-size: 16px;
  }
  .cv_header_info p {
    margin-bottom: 0;
  }
  .cv_body_list {
    display: flex;
    flex-wrap: wrap;
  }
  .cv_body_list li {
    list-style: none;
    width: 60%;
    margin-bottom: 10px;
  }
  .cv_body_list li:nth-child(odd) {
    width: 40%;
  }
  .cv_body_list li {
    display: flex;
    flex-direction: column;
  }
  .cv_body_list li:last-child {
    width: 100%;
  }
  .cv_exper_subtitle {
    text-align: center;
    font-weight: bold;
  }
  .cv_experience_list {
  }
  .cv_experience_list li {
    list-style: none;
    display: flex;
    justify-content: space-between;
  }
  .cv_ex_date {
    width: 220px;
  }
  .cv_experience_list li .cv_ex_info {
    width: calc(100% - 220px);
  }
  .cv_experience_list li .cv_ex_info p {
    margin-bottom: 0;
  }
}
</style>
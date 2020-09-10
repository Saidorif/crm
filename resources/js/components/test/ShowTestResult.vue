<template>
  <div class="show_test_result">
    <Loader v-if="loading" />
    <h2 class="test_title">{{$t('result_test')}}</h2>
    <!-- <ul v-if="userInfo" class="user_info_result">
      <li>
        <em>{{$t('user_info.fio')}} :</em>
        {{userInfo.fio}}
      </li>
      <li>
        <em>{{$t('status_test')}} :</em>
        {{getStatus(userInfo.status)}}
      </li>
      <li>
        <em>{{$t('count_test')}} :</em>
        {{userInfo.limit}} {{$t('in_parsentage')}} 100%
      </li>
      <li>
        <em>{{$t('wrong_answers')}}:</em>
        {{userInfo.wrong_answers ? userInfo.wrong_answers : 0}} {{$t('in_parsentage')}}
        {{countPercentage(userInfo.wrong_answers)}}
      </li>
      <li>
        <em>{{$t('correct_answers')}}</em>
        {{userInfo.true_answers ? userInfo.true_answers : 0}} {{$t('in_parsentage')}}
        {{countPercentage(userInfo.true_answers)}}
      </li>
      <li>
        <em>{{$t('time_test')}}:</em>
        {{getTime}}
      </li>
      <li>
        <em>{{$t('admin_menu.directions')}}:</em>
        {{items.length > 0 ? items[0].category : ''}}
      </li>
    </ul> -->
    <div class="table-responsive" >
      <table class="table table-bordered text-center table-hover table-striped" style="background: #fff;">
        <thead>
          <tr>
            <th scope="col"> {{$t('user_info.fio_short')}}</th>
            <th scope="col">{{$t('directions')}}</th>
            <th scope="col"> {{$t('number_question')}}</th>
            <th scope="col"> {{$t('correct_answers')}}</th>
            <th scope="col">{{$t('wrong_answers')}}</th>
            <th scope="col">{{$t('score')}}</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td scope="row">1</td>
            <td>{{userInfo.fio}}</td>
            <td>{{items.length > 0 ? items[0].category : ''}}</td>
			<td>{{userInfo.limit}}</td>
			<td> {{userInfo.true_answers}}</td>
			<td> {{userInfo.wrong_answers}}</td>
			<td>{{countPercentage(userInfo.true_answers)}}%</td>
          </tr> -->
          <tr v-for="(item,index) in testRes">
            <td>{{userInfo.fio}}</td>
            <td>{{index}}</td>
            <td>{{item.all}}</td>
			<td> {{item.trues}}</td>
			<td> {{ item.all  - item.trues}}</td>
			<td>{{parseInt(item.trues / item.all * 100)  }}%</td>
          </tr>
        </tbody>
      </table>
    </div>
    <h2 class="test_title">{{$t('test_answers')}}</h2>
    <ul v-for="(item,index) in items" v-if="items.length > 0" class="result_test_item">
      <li class="result_quelstion_item">
        {{index+1}} )
        <em>{{item.title}}</em>
      </li>
      <ol type="A" class="result_test_item_variants">
        <template v-for="(q,i) in item.variants">
          <li
            :class="{'correctAnswer': chechAnswer(item.user_choose,q)=='true_answer', 'mistakeAnswer': chechAnswer(item.user_choose,q)=='wrong_answer'}"
          >
            <span>{{q.title}}</span>
          </li>
        </template>
      </ol>
    </ul>
  </div>
</template>
<script>
import { mapActions, mapGetters } from "vuex";
import Loader from "../Loader";
export default {
  components: {
    Loader,
  },
  data() {
    return {
      userInfo: [],
	  items: [],
	  testRes: [],
      category: null,
      loading: true,
    };
  },
  async mounted() {
    await this.actionShowTest(this.$route.params.showTestId);
    if (this.getTest.success) {
      this.userInfo = this.getTest.result.attestat;
      this.testRes = this.getTest.result.arrRes;
      this.items = this.getTest.result.questions;
      this.category = this.items[0].category;
    }
    this.loading = false;
    console.log(this.testRes);
  },
  methods: {
    ...mapActions("test", ["actionShowTest"]),
    countPercentage(number) {
      let summ =
        parseInt(this.userInfo.wrong_answers) +
        parseInt(this.userInfo.true_answers);
      let result = Math.round((parseInt(number) * 100) / summ);
      return result ? result : 0 + " %";
    },
    chechAnswer(userChosen, item) {
      if (
        (userChosen == item.id && item.is_true == 1) ||
        (userChosen != item.id && item.is_true == 1)
      ) {
        return "true_answer";
      } else if (userChosen == item.id && item.is_true == 0) {
        return "wrong_answer";
      } else {
        return "";
      }
    },
    getStatus(status) {
      if (status == "complete") {
        return "завершен";
      } else if (status == "progress") {
        return "в процессе";
      } else if (status == "start") {
        return "новый";
      }
    },
  },
  computed: {
    ...mapGetters("test", ["getTest"]),
    getTime() {
      // return parseFloat(parseInt(this.userInfo.time)/60) + ' минут'
      return this.userInfo.time + " секунд";
    },
  },
};
</script>
<style scoped>
.true_answer {
  color: green;
}
.wrong_answer {
  color: red;
}
.test_title {
  font-weight: bold;
  text-align: center;
  margin-bottom: 20px;
  text-transform: uppercase;
}
</style>
 <template>
	<div class="start_test">
		<div class="card">
		  	<div class="card-header">
			    <h4 class="title_user">
			    	<i  class="peIcon pe-7s-browser"></i>
				    {{ $t('start_test') }}
				</h4>
		  	</div>
		  	<div class="card-body">
			  <form @submit.prevent.enter="startTest" >
					<div class="row">
						<div class="form-group col-md-6">
							<label class="typo__label"> {{ $t('admin_menu.directions') }}</label>
							<multiselect 
								v-model="selectedCategory" 
								:placeholder="$t('admin_menu.select_directions')" 
								label="name" 
								track-by="id"
								:options="getCategories" 
								:multiple="true" 
								:taggable="true" 
								:slot-scope="id"
							></multiselect>
					  	</div>
						<div class="form-group col-md-6">
						    <label for="fio">{{$t('user_info.fio')}}</label>
						    <input 
						    	type="text" 
						    	class="form-control input_style" 
						    	id="fio" 
						    	:placeholder="$t('user_info.fio')"
						    	v-model="form.fio"
						    	:class="isRequired(form.fio) ? 'isRequired' : ''"  
					    	>
					  	</div>
						<div class="form-group col-md-6">
						    <label for="birthday">{{ $t('user_info.date_birthday') }}</label>
							<date-picker v-model="form.date_birth" valueType="format" :class="isRequired(form.date_birth) ? 'isRequired' : ''" ></date-picker>
					  	</div>
						<div class="form-group col-md-6 double_input">
						    <label for="passport">  {{ $t('user_info.passport_number_seria') }}</label>
							<input type="text" class="form-control input_style"  v-model="form.pasport_seriya"  :class="isRequired(form.pasport_seriya) ? 'isRequired' : ''" maxlength="2">
							<input type="text" pattern="\d*" maxlength="7" class="form-control input_style"  v-model="form.pasport_number" :class="isRequired(form.pasport_number) ? 'isRequired' : ''"  >
					  	</div>
						<div class="form-group col-md-6">
						    <label for="phoneNum">{{ $t('user_info.phone_number') }} </label>
							<input type="text" class="form-control input_style"  v-model="form.phone"  :class="isRequired(form.phone) ? 'isRequired' : ''" placeholder="+998901234567" >
					  	</div>
						<div class="form-group col-md-6">
						    <label for="position">{{ $t('user_info.position') }}</label>
							<input type="text" class="form-control input_style"  v-model="form.position"  :class="isRequired(form.position) ? 'isRequired' : ''" :placeholder="$t('user_info.position')">
					  	</div>
				  		<div class="form-group col-lg-12 form_btn">
						  	<button type="submit" class="btn btn-primary btn_save_category btn_start_test">
						  		<i class="pe-7s-play"></i>
							  	{{ $t('begin_test') }}
							</button>	
				  	  	</div>
					</div>
				</form>
	  		</div>
	  	</div>	
	</div>
</template>
<script>
	import {mapActions, mapGetters} from 'vuex'
	import {TokenService} from './../../services/storage.service'
	import Multiselect from 'vue-multiselect'
	import DatePicker from 'vue2-datepicker';
	export default{
		components: {
			Multiselect,
			DatePicker
		},
		data(){
			return{
				form:{
					category_id:[],
					fio:'',
					date_birth: '',
					pasport_seriya: '',
					pasport_number: '',
					phone: '',
					position: '',
				},
				selectedCategory: [],
				requiredInput:false,
			}
		},
		computed:{
			...mapGetters('test',['getTests','getMassage']),
			...mapGetters('category',['getCategories']),
			checkInputs(){
				if(this.selectedCategory.length &&  this.form.fio &&  this.form.date_birth  &&  this.form.pasport_seriya  &&  this.form.pasport_number &&  this.form.phone &&  this.form.position){
					return true
				}else{
					return false
				}
			}
		},
		async mounted(){
			await this.actionCategoryList()
		},
		methods:{
			...mapActions('category',['actionCategoryList']),
			...mapActions('test',['actionStartTest']),
			isRequired(input){
	    		return this.requiredInput && input === '';
			},
		    async startTest(){
		    	if (this.checkInputs) {
					this.form.category_id = []
					this.selectedCategory.forEach(element => {
						this.form.category_id.push(element.id)
					});
		    		await this.actionStartTest(this.form)
					TokenService.saveGuestInfo(this.form)
			    	if (this.getTests.success){
			    			this.$router.push("/crm/test/test-for-guest");
			    			toast.fire({
								type: "success",
								icon: 'success',
								title: "Тест начался!"
							});
			    		}
			    	else if(this.getTests.error && this.getTests.message == 'Big limit...'){
			    		toast.fire({
								type: "error",
								icon: 'error',
								title: "Эти типы вопросов не достаточно в базе данных!"
							});
			    	}
		    	}else{
		    		this.requiredInput = true
		    	}
		    }
		}
	}
</script>
<style scoped>
	.double_input{
		display: flex;
		flex-wrap: wrap;
	}
	.double_input .input_style:nth-child(2){
		width: 60px;
		border-top-right-radius: 0px;
		border-bottom-right-radius: 0px;
		border-right: none;
	}
	.double_input .input_style:nth-child(3){
		width: calc(100% - 60px);
		border-top-left-radius: 0px;
		border-bottom-left-radius: 0px;
	}
	.double_input label{
		width: 100%;
	}
	.btn_start_test{
		margin-left: auto;
		font-size: 26px;
		height: 50px;
		margin-right: auto;
		font-weight: bold;
		margin-top: 20px;
		border-width: 2px;
		display: flex;
    	align-items: center;
	}
	.btn_start_test i{
		font-size: 30px;
		margin-right: 10px;
	}
</style>
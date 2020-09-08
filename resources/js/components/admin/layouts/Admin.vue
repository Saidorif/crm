<template>
  <div class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="pe-7s-menu" style="font-size: 30px;line-height: 21px;"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <LangSwitcher />
      </li>
      <li class="nav-item">
        <a href="#" class="logout_btn" @click.prevent="logoutProfile"> <i class="pe-7s-next-2"></i>{{ $t('logout') }} </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar">
    <!-- Brand Logo -->
    <router-link class="brand-link" to="/crm">
      <span class="brand-text font-weight-light logoText">
        <!-- <img src="/logo.png"> -->
        TEST
      </span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column sidebar-menu treeview" data-widget="treeview" role="menu" data-accordion="false" >
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
             <!-- v-if="$can('profile', 'UserController')" -->
            <router-link to="/crm/dashboard" class="nav-link" v-if="$can('index', 'DashboardController')">
              <span class="peIcon pe-7s-rocket" style="font-size: 20px;"></span>
              <p>
                {{ $t('admin_menu.admin_panel') }}
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/profile" v-if="$can('profile', 'UserController')">
              <i class="peIcon pe-7s-user"></i>
              <p>
                
                {{ $t('admin_menu.my_info') }}
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/test/test-user"  v-if="$can('userindex', 'AttestatController')">
              <i class="peIcon pe-7s-note2"></i>
              <p>
                {{ $t('admin_menu.tests') }}  <span class="badge badge-warning">user</span>
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/category" v-if="$can('index', 'TestCategoryController')">
              <span class="peIcon pe-7s-drawer" style="font-size: 20px;"></span>
              <p>
                {{ $t('admin_menu.directions') }}
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/question" v-if="$can('index', 'QuestionController')">
              <span class="peIcon pe-7s-note" style="font-size: 20px;"></span>
              <p>
                
                {{ $t('admin_menu.questions') }}
              </p>
            </router-link>
          </li>
          <li class="nav-item has-treeview"  v-if="$can('list', 'TestCategoryController')">
            <a href="#" class="nav-link" >
              <span class="peIcon pe-7s-note2" style="font-size: 20px;"></span>
              <p>
                 {{ $t('admin_menu.tests') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/test/start-test">
                  <p>
                     {{ $t('admin_menu.create_test') }}
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/test/list">
                  <p>
                    {{ $t('admin_menu.test_list') }}
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/employee"  v-if="$can('index', 'EmployeeController')">
              <i class="peIcon pe-7s-users"></i>
              <p>
                {{ $t('admin_menu.employee') }} 
              </p>
            </router-link>
          </li>
<!--           <li class="nav-item">
            <router-link class="nav-link" to="/crm/position" v-if="$can('index', 'PositionController')">
              <i class="peIcon pe-7s-graph1"></i>
              <p>
                Должность
              </p>
            </router-link>
          </li> -->
          <li class="nav-item has-treeview" v-if="$can('index', 'RoleController')">
            <a href="#" class="nav-link">
              <span class="peIcon pe-7s-settings" style="font-size: 20px;"></span>
              <p>
                {{ $t('admin_menu.settings') }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/role">
                  <p>
                    Role
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/conts">
                  <p>
                    Controller
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/action">
                  <p>
                    Actions
                  </p>
                </router-link>
              </li>
            </ul>
          </li>  
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar> 
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="#">MIRXAN </a>.</strong>
    All rights reserved.
  </footer>
</div>
</div>
</template>

<script>
  import { mapActions, mapGetters } from "vuex";
  import {TokenService} from './../../../services/storage.service'
  	import LangSwitcher from '../../LangSwitcher'
export default {
		components:{
			LangSwitcher
		},
  data(){
    return {
      
    }
  },
  computed: {
    ...mapGetters(['getUser']),
  },
  async mounted(){
    await this.profileUser()


  },
  methods: {
    ...mapActions(['logout','profileUser']),
    logoutProfile(){
      this.logout();
    },
    
  }
};
</script>

<style scoped>
  .logoText{
    font-size: 40px;
    font-weight: 900;
    text-align: center;
    color: #000;
  }
</style>
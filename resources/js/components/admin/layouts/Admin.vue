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
        <a href="#" class="logout_btn" @click.prevent="logoutProfile"> <i class="pe-7s-next-2"></i> Logout</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar">
    <!-- Brand Logo -->
    <router-link class="brand-link" to="/crm">
      <span class="brand-text font-weight-light">
        <img src="/logo.png">
      </span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <router-link to="/crm/dashboard" class="nav-link">
              <span class="peIcon pe-7s-rocket" style="font-size: 20px;"></span>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/profile">
              <i class="peIcon pe-7s-user"></i>
              <p>
                Profile
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/test/test-user">
              <i class="peIcon pe-7s-note2"></i>
              <p>
                Test USER
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/category">
              <span class="peIcon pe-7s-drawer" style="font-size: 20px;"></span>
              <p>
                Управления
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/question">
              <span class="peIcon pe-7s-note" style="font-size: 20px;"></span>
              <p>
                Question
              </p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <span class="peIcon pe-7s-note2" style="font-size: 20px;"></span>
              <p>
                Test
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/test/start-test">
                  <p>
                    Start Test
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/test/list">
                  <p>
                    Test List
                  </p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/employee">
              <i class="peIcon pe-7s-users"></i>
              <p>
                Employee
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/crm/position">
              <i class="peIcon pe-7s-graph1"></i>
              <p>
                Должность
              </p>
            </router-link>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <span class="peIcon pe-7s-settings" style="font-size: 20px;"></span>
              <p>
                Setting users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/role">
                  <i class="peIcon pe-7s-id"></i>
                  <p>
                    Role
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/conts">
                  <i class="peIcon pe-7s-box1"></i>
                  <p>
                    Controller
                  </p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" to="/crm/action">
                  <i class="peIcon pe-7s-box1"></i>
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
export default {
  components: {
  },
  data(){
    return {
      
    }
  },
  computed: {
   
  },
  methods: {
    ...mapActions(['logout']),
    logoutProfile(){
      this.logout();
    },
  }
};
</script>

<style scoped>

</style>
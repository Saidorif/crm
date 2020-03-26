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
        <a href="#" @click.prevent="logoutProfile">Logout</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar">
    <!-- Brand Logo -->
    <router-link class="brand-link" to="/crm">
      <span class="brand-text font-weight-light">ADMIN DASHBOARD</span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <span class="peIcon pe-7s-rocket" style="font-size: 20px;"></span>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <p>Dashboard v1</p>
                </a>
              </li>
            </ul>
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
            <router-link class="nav-link" to="/crm/category">
              <i class="peIcon pe-7s-drawer"></i>
              <p>
                Category
              </p>
            </router-link>
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
  .content-wrapper{
    background: #f1f4f6;
    padding-top: 30px;
  }
  .main-sidebar{
    background: #fff;
  }
  .main-header{
    box-shadow: 0 0.46875rem 2.1875rem rgba(4,9,20,0.03), 0 0.9375rem 1.40625rem rgba(4,9,20,0.03), 0 0.25rem 0.53125rem rgba(4,9,20,0.05), 0 0.125rem 0.1875rem rgba(4,9,20,0.03);
    background: #3f6ad8;
    color: #fff;
  }
  .navbar-light .navbar-nav .nav-link{
    color: #fff;
    font-size: 20px;
    line-height: initial;
  }
  .brand-link.open.active{
    background: #5279dc;
    color: #fff;
    text-align: center;
  }
  .card{
    box-shadow: 0 0.46875rem 2.1875rem rgba(4,9,20,0.03), 0 0.9375rem 1.40625rem rgba(4,9,20,0.03), 0 0.25rem 0.53125rem rgba(4,9,20,0.05), 0 0.125rem 0.1875rem rgba(4,9,20,0.03);
  }
  .peIcon{
    text-align: center;
    width: 34px;
    height: 34px;
    line-height: 33px;
    font-size: 22px;
    transition: color 300ms;
    color: #3f6ad8;
  }
  .nav-sidebar .nav-item>.nav-link{
    display: flex;
    align-items: center;
    transition-delay: 300ms;
  }
  .nav-pills .nav-link.active, .nav-pills .show > .nav-link{
    color: #3f6ad8;
    background: #e0f3ff;
    font-weight: bold;
    font-weight: bold;
  }
  .nav-sidebar .nav-treeview{
    transition: padding 300ms;
    padding: .5em 0 0 2rem;
    position: relative;
  }
  .nav-sidebar .nav-treeview::before{
    content: '';
    height: 100%;
    opacity: 1;
    width: 3px;
    background: #e0f3ff;
    position: absolute;
    left: 32px;
    top: 0;
    border-radius: 15px;
  }
  .nav-sidebar .menu-open > .nav-link{
    font-weight: bold;
  }
  .nav-sidebar .nav-link>.right, .nav-sidebar .nav-link>p>.right {
    position: absolute;
    right: 1rem;
    top: 18px;
  }
</style>
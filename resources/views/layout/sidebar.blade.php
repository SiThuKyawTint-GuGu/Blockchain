<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{\Config::get('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <a href="{{route('dashboard')}}" class="nav-link {{Request::segment(1) == '' ? 'active' : ''}}">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('customer.index')}}" class="nav-link {{Request::segment(1) == 'customer' ? 'active' : ''}}">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Users
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('withdraw.index')}}" class="nav-link {{Request::segment(1) == 'withdraw' ? 'active' : ''}}">
                  <i class="nav-icon fas fa-minus-circle"></i>
                  <p>
                    Withdraws
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('reward_setting.index')}}" class="nav-link {{Request::segment(1) == 'reward_setting' ? 'active' : ''}}">
                  <i class="nav-icon fas fa-plus-circle"></i>
                  <p>
                    Reward Setting
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('setting.index')}}" class="nav-link {{Request::segment(1) == 'setting' ? 'active' : ''}}">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>
                     Setting
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <form id="logout-form" action="{{route('logout')}}" method="post">
                    @csrf
                </form>
                <a style="cursor: pointer" onclick="if(confirm('Are you sure you want to logout?')){
                        document.getElementById('logout-form').submit();
                    }" class="nav-link">
                  <i class="nav-icon fa fa-sign-out-alt"></i>
                  <p>
                    Logout
                  </p>
                </a>
              </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
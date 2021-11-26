<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('index') }}" class="brand-link">
        <img src="{{ asset('public/site-asset/images/logo.webp') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 1.8">
        <span class="brand-text font-weight-light">ChezDon</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{ asset('public/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="{{ route('admin.profile') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ (\Request::route()->getName() == 'admin.dashboard') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                          Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.user.all') }}" class="nav-link {{ (\Request::route()->getName() == 'admin.user.all' || \Request::route()->getName() == 'admin.user.create' || \Request::route()->getName() == 'admin.user.save' || \Request::route()->getName() == 'admin.user.edit' || \Request::route()->getName() == 'admin.user.update' || \Request::route()->getName() == 'admin.user.status') ? ' active' : '' }}">
                      <i class="nav-icon fas fa-users"></i>
                      <p>
                          User Management
                      </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.meal.type.all') }}" class="nav-link {{ (\Request::route()->getName() == 'admin.meal.type.all' || \Request::route()->getName() == 'admin.meal.type.status' || \Request::route()->getName() == 'admin.meal.type.create' || \Request::route()->getName() == 'admin.meal.type.save' || \Request::route()->getName() == 'admin.meal.type.edit' || \Request::route()->getName() == 'admin.meal.type.update') ? ' active' : '' }}">
                      <i class="nav-icon fas fa-utensil-spoon"></i>
                      <p>
                          Meal Type Management
                      </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.meal.all') }}" class="nav-link {{ (\Request::route()->getName() == 'admin.meal.all' || \Request::route()->getName() == 'admin.meal.create' || \Request::route()->getName() == 'admin.meal.save' || \Request::route()->getName() == 'admin.meal.edit' || \Request::route()->getName() == 'admin.meal.update') ? ' active' : '' }}">
                      <i class="nav-icon fas fa-utensils"></i>
                      <p>
                          Meal Management
                      </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.order.all') }}" class="nav-link {{ (\Request::route()->getName() == 'admin.order.all' || \Request::route()->getName() == 'admin.order.view.edit') ? ' active' : '' }}">
                      <i class="nav-icon fas fa-cash-register"></i>
                      <p>
                          Order Management
                      </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.account.withdraw.request.all') }}" class="nav-link {{ (\Request::route()->getName() == 'admin.account.withdraw.request.all' || \Request::route()->getName() == 'admin.account.withdraw.request.detail' || \Request::route()->getName() == 'admin.account.withdraw.request.detail.update') ? ' active' : '' }}">
                      <i class="nav-icon fas fa-hand-holding-usd"></i>
                      <p>
                          Account Management
                      </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.contact.message.all') }}" class="nav-link {{ (\Request::route()->getName() == 'admin.contact.message.all' || \Request::route()->getName() == 'admin.contact.message.view') ? ' active' : '' }}">
                      <i class="nav-icon fas fa-comments"></i>
                      <p>
                          Contact Messages
                      </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.setting.index') }}" class="nav-link {{ (\Request::route()->getName() == 'admin.setting.index') ? ' active' : '' }}">
                      <i class="nav-icon fas fa-cogs"></i>
                      <p>
                          App Settings
                      </p>
                    </a>
                </li>
            </ul>
        </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
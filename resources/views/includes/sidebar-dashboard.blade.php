<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard',['locale' => config('app.locale')]) }}" class="brand-link">
      <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('dashboard',['locale' => config('app.locale')]) }}" class="nav-link {{ $title==__('dashboard.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>{{ __('dashboard.dashboard') }}</p>
          </a>
        </li>
        <li class="nav-item {{ in_array($title,TitleHelper::all_title('user-management')) ? 'menu-is-opening menu-open' : '' }}">
          <a href="#" class="nav-link {{ in_array($title,TitleHelper::all_title('user-management')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>{{ __('dashboard.user-management') }}<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('users',['locale' => config('app.locale')]) }}" class="nav-link {{ in_array($title,[...TitleHelper::all_title('users')]) ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>{{ __('dashboard.users') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('roles',['locale' => config('app.locale')]) }}" class="nav-link {{ in_array($title,[...TitleHelper::all_title('roles')]) ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-cog"></i>
                <p>{{ __('dashboard.roles') }}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('permission-roles',['locale' => config('app.locale')]) }}" class="nav-link {{ in_array($title,[...TitleHelper::all_title('permission-roles')]) ? 'active' : '' }}">
                <i class="nav-icon fas fa-key"></i>
                <p>{{ __('dashboard.permission-roles') }}</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
  </aside>
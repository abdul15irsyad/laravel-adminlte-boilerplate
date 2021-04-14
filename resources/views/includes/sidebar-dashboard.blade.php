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
        <li class="nav-item">
          <a href="{{ route('users',['locale' => config('app.locale')]) }}" class="nav-link {{ $title==__('dashboard.users') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>{{ __('dashboard.users') }}</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
  </aside>
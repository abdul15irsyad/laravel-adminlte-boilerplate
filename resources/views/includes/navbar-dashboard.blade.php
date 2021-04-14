<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="{{ __('dashboard.search') }}" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item mr-3">
            <a class="nav-link" href="#" title="{{ __('dashboard.notification') }}">
                <i class="far fa-bell"></i>
                @if(auth()->user()->unreadNotifications->count()>0)
                <span class="badge badge-danger navbar-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item dropdown">
            <a href="#" class="btn btn-default" data-toggle="dropdown">
                <span>{{ auth()->user()->user_username }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user fa-fw mr-2"></i> {{ __('dashboard.profile') }}
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item hover-danger" data-toggle="modal" data-target="#modal-logout">
                    <i class="fas fa-sign-out-alt fa-fw mr-2"></i> {{ __('dashboard.logout') }}
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
<!-- Modal Logout -->
<div class="modal fade modal-logout" id="modal-logout" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('dashboard.logout-confirmation') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{!! __('dashboard.logout-confirmation-text',['username' => auth()->user()->user_username]) !!}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('dashboard.cancel') }}</button>
                <a href="{{ route('logout',['locale' => config('app.locale')]) }}" class="btn btn-danger btn-logout">{{ __('dashboard.yes-logout') }}</a>
            </div>
        </div>
    </div>
</div>

<!-- Main Footer -->
<footer class="main-footer  text-sm text-secondary">
  <div class="container-fluid">
    <div class="row justify-content-between">
      <div class="col-md-6 col-12 text-md-left text-center">
        <span>Copyright &copy; {{ date('Y') }} <a href="{{ route('dashboard',['locale' => config('app.locale')]) }}" class="inherit"><b>{{ config('app.name') }}</b></a>. All rights reserved.</span>
      </div>
      <div class="col-md-6 col-12 text-md-right text-center">
        @include('includes.locale')
      </div>
    </div>
  </div>
</footer>
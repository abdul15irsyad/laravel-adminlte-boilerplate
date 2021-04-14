<!-- Main Footer -->
<footer class="main-footer d-flex justify-content-between text-sm text-secondary">
  <div class="col-md-6">
    <span>Copyright &copy; {{ date('Y') }} <a href="{{ route('dashboard',['locale' => config('app.locale')]) }}" class="inherit"><b>{{ config('app.name') }}</b></a>. All rights reserved.</span>
  </div>
  <div class="text-right">
    @include('includes.locale')
  </div>
</footer>
@extends('templates.master',['title'=>'404'])

@section('body')
<body>
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper d-flex justify-content-center w-100 m-0 p-3">
    <!-- Main content -->
    <section class="content d-flex align-self-center">
      <div class="error-page d-flex align-items-center my-0">
        <h2 class="headline text-warning"><b>404</b></h2>
        <div class="error-content ml-5">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
          <p>{!! __('auth.404-not-found',['link'=>route('home')]) !!}</p>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
@endsection
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3 class="text-bold m-0">{{ $content_title }}</h3>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          @foreach($breadcumbs as $breadcumb)
          <li class="breadcrumb-item {{ $breadcumb['status'] }}">
            @if($breadcumb['status']!='active')
            <a href="{{ $breadcumb['link'] }}">{{ $breadcumb['text'] }}</a>
            @else
            {{ $breadcumb['text'] }}
            @endif
          </li>
          @endforeach
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
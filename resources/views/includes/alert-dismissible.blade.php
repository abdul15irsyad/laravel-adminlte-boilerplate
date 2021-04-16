@if($message)
<div class="alert alert-default-{{ $type }} alert-dismissible text-sm">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <span>{{ $message }}</span>
</div>
@endif
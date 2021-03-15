@if( Session::has("success") )
<div class="alert alert-success alert-block" role="alert">
    <button class="close" data-dismiss="alert"></button>
    {{ Session::get("success") }}
</div>
@endif
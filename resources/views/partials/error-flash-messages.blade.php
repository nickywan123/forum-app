@if( Session::has("error") )
<div class="alert alert-danger alert-block" role="alert">
    <button class="close" data-dismiss="alert"></button>
    {{ Session::get("error") }}
</div>
@endif
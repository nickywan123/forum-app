@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row">
     <div class="col-md-6">
         <h2>My Profile Information:</h2>
         <h5>Name: {{$profileInfo->name}}</h5>
         <h5>Email: {{$profileInfo->email}}</h5>
         <h5>Placeholder:</h5> 
     </div>
    </div>    
</div>

@endsection
@extends('layouts.app')


@section('content')

 <div class="container">
     <div class="row">
         <div class="col-md-8 offset-md-2">
            <div class="pb-2 mt-4 mb-3 border-bottom">
              <div class="row">
                <div class="col-md-6">
                  <h1>{{$profileUser->name}}</h1>
                </div>
                <div class="offset-md-3 col-md-3 mt-2">
                  <a href="{{route('profile.info',[$profileUser])}}">Profile Information</a>
                </div>
              </div>
            </div>

            @foreach($activities as $date => $activity)
              <h4 class="page-header">{{$date}}</h4>
              @foreach($activity as $record)
                @if(view()->exists("profiles.activities.{$record->type}"))
                    @include("profiles.activities.{$record->type}",['activity'=>$record]) 
                @endif
              @endforeach
            @endforeach
        </div>
     </div>
</div>

@endsection
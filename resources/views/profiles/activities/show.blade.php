@extends('layouts.app')


@section('content')

 <div class="container">
     <div class="row">
         <div class="col-md-8 offset-md-2">
            <div class="pb-2 mt-4 mb-3 border-bottom">
              <div class="row">
                <div class="col-md-6">
                 <h2>Latest Activity Feed</h2>
                </div>
              </div>
            </div>

            @forelse($activities as $date => $activity)
              <h4 class="page-header">{{$date}}</h4>
              @foreach($activity as $record)
                @if(view()->exists("profiles.activities.{$record->type}"))
                    @include("profiles.activities.{$record->type}",['activity'=>$record]) 
                @endif
              @endforeach
            @empty 
              <p>There are no activities in your feed....</p>
            @endforelse
        </div>
     </div>
</div>

@endsection
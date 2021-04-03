
@component('profiles.activities.activity')

@slot('heading')


@if($activity->subject->favorited_type === 'App\Reply')
<a href="{{$activity->subject->favorited->path()}}">{{$profileUser->name}} favorited a reply</a> 
@else
<a href="{{$activity->subject->favorited->path()}}">{{$profileUser->name}} favorited a thread</a> 

@endif

@endslot

@slot('body')
 {{$activity->subject->favorited->body}}
@endslot

@endcomponent
  



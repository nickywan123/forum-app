@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @forelse($threads as $thread)
            <div class="card mb-3">
                <div class="card-header">
                    <div class="level">
                        <h4 class="flex">
                         <a href="{{$thread->path()}}">{{$thread->title}}</a>
                        </h4>
                        <a href="{{$thread->path()}}">{{$thread->replies_count}} {{Str::plural('reply',$thread->replies_count)}}</a>
                    </div>
                </div>
                <div class="card-body">
                     <article>
                        <div class="body">{{$thread->body}}</div>
                     </article>
                </div>
            </div>
            @empty
                <p>There are no threads at the moment.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

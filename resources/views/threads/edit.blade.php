@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Thread</div>

                <div class="card-body">
                    <form method="POST" action="{{route('threads.update',[$thread])}}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="channel_id">Select A Channel:</label>
                            <select name="channel_id" id="channel_id" class="form-control">
                                <option value="{{$thread->channel_id}}">{{$channel}}</option>
                                @foreach($channels as $channel)
                                 <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected' : ''}}>
                                    {{$channel->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="title" name="title" class="form-control" id="title" placeholder="Title" value="{{$thread->title}}" required>
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea class="form-control" id="body" name="body" rows="8" placeholder="Enter your text" required >{{$thread->body}}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Thread</button>
                        </div>
                        @if(count($errors))
                        <ul class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

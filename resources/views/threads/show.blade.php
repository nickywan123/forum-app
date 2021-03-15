@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="level">
                        <span class="flex"><a href="{{route('profile',$thread->creator->name)}}">{{$thread->creator->name}}</a> posted:
                            {{$thread->title}}
                        </span>
                        @if(auth()->check())
                        <favorite-thread v-bind:thread="{{$thread}}"></favorite-thread>
                        @endif
                        @can('update',$thread)
                        <a href="{{$thread->path()}}/edit" class="btn btn-link">Edit Thread</a>
                        <form action="{{$thread->path()}}" method="POST">
                            @csrf
                            @method('delete')
                            <button class="btn btn-link" type="submit">Delete Thread</button>
                        </form>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                {{$thread->body}}
                </div>
            </div>
            @foreach($replies as $reply)
             @include('threads.reply')
            @endforeach
            <div class="mt-5">
                {{$replies->links()}}
            </div>
            @if(auth()->check())
            <form method="POST" action="{{$thread->path() . '/replies'}}">
               @csrf
               <div class="form-group mt-2">
                   <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body" rows="5" placeholder="Write a reply">{{ old('body') }}</textarea>
                   @error('body')
                    <div class="alert alert-danger">{{ $message }}</div>
                   @enderror
               </div>     
               <div class="d-flex justify-content-between">
                   <button type="submit" class="btn btn-dark">Post</button>
                   <p class="text-dark pr-4">Share to:</p>              
               </div>  
               <div class="d-flex justify-content-end ">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}" target="_blank"><span class="fab fa-facebook-square fa-3x pr-2" style="color:#3b5998"></span></a>
                <a href="https://twitter.com/intent/tweet?url={{url()->current()}}" target="_blank"><span class="fab fa-twitter fa-3x pr-2" style="color:#00acee"></span></a>
                <a href="https://wa.me/?text={{url()->current()}}" target="_blank" ><span class="fab fa-whatsapp-square fa-3x" style="color:#4FCE5D"></span></a>
               </div>
            </form>      
             @else   
             <p>Please <a href="{{route('login')}}">sign in</a> to participate in the forum</p> 
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>
                        This thread was posted {{$thread->created_at->diffForHumans()}}
                        by <a href="#">{{$thread->creator->name}}</a>
                        and has {{$thread->replies_count}} {{Str::plural('comment',$thread->replies_count)}}
                    </p>
                        @if(auth()->check())
                        <button class="btn btn-secondary"  @if (!$subscription) style="display: none;" @endif id="unsubscribe">Unsubscribe</button> 
                        <button class="btn btn-danger"  @if ($subscription) style="display: none;" @endif id="subscribe">Subscribe</button>
                        @endif
                </div>
            </div>
        </div>
    </div>  
</div>

<script type="application/javascript">

    $(document).ready(function(){
        $('#subscribe').click(function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
    
            $.ajax({
                url: "{{route('subscription.store',[$thread->channel,$thread->id])}}",
                method:'POST',
                data: {
                },
                success:function(response){
                    $('div.flash-message').html(response);
                    $('#subscribe').hide();
                    $('#unsubscribe').show();
                    hideMessage();
                   
                },
                error:function(error){
                    console.log(error);
                }
            });
        });


        $('#unsubscribe').click(function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
    
            $.ajax({
                url: "{{route('subscription.delete',[$thread->channel,$thread->id])}}",
                method:'DELETE',
                data: {
                },
                success:function(response){
                    $('div.flash-message').html(response);
                    $('#subscribe').show();
                    $('#unsubscribe').hide();
                    hideMessage();
                   
                },
                error:function(error){
                    console.log(error);
                }
            });
        });

        function hideMessage(){
            $('div.flash-message').fadeOut(5000);
        }

    });

</script>
@endsection

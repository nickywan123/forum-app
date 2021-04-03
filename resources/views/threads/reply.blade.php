<div id="reply-{{$reply->id}}" class="card mt-2">
    <div class="card-header">
      <div class="level">
        <h5 class="flex">
        <a href="{{route('profile.show',$reply->owner->name)}}">{{$reply->owner->name}}</a> 
            said {{$reply->created_at->diffForHumans()}}....
        </h5>
        @if(auth()->check())
        <favorite v-bind:reply="{{$reply}}"></favorite>
        @endif
      </div>
    </div>
    <div id="reply-body-{{$reply->id}}" class="card-body">
      @include('threads.replies.reply-body')
    </div>
    <div id="reply-form-{{$reply->id}}">
      <!--render reply form here from edit.blade.php -->
    </div>
    @can('update',$reply)
      <div id="reply-footer-{{$reply->id}}" class="card-footer">
        <div class="row">
          <div class="col-md-1">
          <button type="submit" id="editReply-{{$reply->id}}"  class="btn btn-primary btn-sm btn-width" >Edit</button>
          </div>
          <div class="offset-md-1 col-md-1">
            <form action="/replies/{{$reply->id}}" method="POST">
              @csrf
              @method('delete')
              <button type="submit" class="btn btn-danger btn-sm btn-width">Delete</button>
            </form>
          </div>
        </div> 
      </div>
    @endcan
  </div>

<script type="application/javascript">

    $(document).ready(function(){
        $('#editReply-{{$reply->id}}').click(function(e){
           e.preventDefault();  
           e.stopImmediatePropagation(); 
            $.ajax({
                url:"{{route('reply.edit',$reply->id)}}",
                method:'GET',
                data: {
                },
                success:function(response){
                    $('#reply-body-{{$reply->id}}').hide();
                    $('#reply-footer-{{$reply->id}}').hide();
                    $('#reply-form-{{$reply->id}}').html(response).show();
                },
                error:function(error){
                    alert('ERROR');
                    console.log(error);
                }
            });
        });
        
     });

</script>




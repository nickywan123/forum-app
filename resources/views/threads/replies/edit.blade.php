<form id="edit-form-{{$reply->id}}">
    <div class="form-group mt-2">
        <textarea class="form-control" name="body" id="body-{{$reply->id}}" rows="5">{{$reply->body}}</textarea>
    </div>
    <div class="alert-message " id="replyError-{{$reply->id}}" style="color:red;"></div>
    <button type="submit" id="updateReply-{{$reply->id}}" class="btn btn-primary btn-sm">Update Reply</button>  
    <button type="submit" id="cancelReply-{{$reply->id}}" class="btn btn-danger btn-sm">Cancel</button>
</form>

<script type="application/javascript">


     $(document).ready(function(){
        $('#updateReply-{{$reply->id}}').click(function(e){
           e.preventDefault();
           e.stopImmediatePropagation();
           $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
            $.ajax({
                url:"{{route('reply.update',$reply->id)}}",
                method:'PUT',
                data: {
                    body: $('#body-{{$reply->id}}').val()
                },
                success:function(response){
                    $('#reply-footer-{{$reply->id}}').show();
                    $('#edit-form-{{$reply->id}}').hide();
                    $('#reply-body-{{$reply->id}}').html(response).show();
                },
                error:function(error){
                    console.log(error);
                    $('#replyError-{{$reply->id}}').text('Please enter your reply');
                }
            });
        });

        $('#cancelReply-{{$reply->id}}').click(function(e){
            e.preventDefault();
            $('#reply-footer-{{$reply->id}}').show();
            $('#edit-form-{{$reply->id}}').hide();
            $('#reply-body-{{$reply->id}}').show();            
        });
     });


</script>
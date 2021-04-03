@extends('layouts.app')


@section('content')

<div class="container">
  <div class="row my-2">
      <div class="col-lg-8 order-lg-2">
          <ul class="nav nav-tabs">
              <li class="nav-item">
                  <a href="" data-target="#profile" data-toggle="tab" class="nav-link  {{ count($errors) || Session::has('edit') || Session::has('password') ? '' : 'active' }}">Profile</a>
              </li>
              @can('update',$user)
              <li class="nav-item">
                  <a href="" data-target="#edit" data-toggle="tab" class="nav-link  {{ $errors->has('name') || Session::has('edit') ? 'active' : '' }}">Edit</a>
              </li>
              <li class="nav-item">
                <a href="" data-target="#change-password" data-toggle="tab" class="nav-link {{$errors->has('current-password') || $errors->has('new-password') || $errors->has('new-password_confirmation')  || Session::has('password') ? 'active' : ''}} ">Change Password</a>
            </li>
              @endcan
          </ul>
          <div class="tab-content py-4">
              <!--Profile tab -->
              <div class="tab-pane {{ count($errors) || Session::has('edit') || Session::has('password') ? '' : 'active' }}" id="profile">
                  <h5 class="mb-3">User Profile</h5>
                  <div class="row">
                      <div class="col-md-6">
                          <h6>Name</h6>
                          <p>
                             {{$user->name}}
                          </p>
                          <h6>Email</h6>
                          <p>
                             {{$user->email}}
                          </p>
                      </div>
                  </div>              
              </div>
               <!--Edit tab -->
              <div class="tab-pane {{ $errors->has('name') || Session::has('edit')  ? 'active' : '' }} " id="edit">
                  <form method="POST" action="{{route('profile.update',[$user])}}">
                      @csrf
                      @method('PATCH')
                      <div class="form-group row">
                          <input type="hidden" name="edit" value="edit">
                          <label class="col-lg-3 col-form-label form-control-label">Name</label>
                          <div class="col-lg-9">
                              <input class="form-control" type="text" id="name" name="name" onkeyup="checkInput()" value="{{$user->name}}" >
                          </div>
                      </div>
                      <div class="form-group row">
                          <label class="col-lg-3 col-form-label form-control-label">Email</label>
                          <div class="col-lg-9">
                              <input class="form-control" type="email" name="email" value="{{$user->email}}" disabled>
                          </div>
                      </div>                  
                      <div class="form-group row">
                          <label class="col-lg-3 col-form-label form-control-label"></label>
                          <div class="col-lg-9">
                              <input type="reset" class="btn btn-secondary" value="Cancel">
                              <button type="submit" id="save-btn" class="btn btn-primary" disabled>Save Changes</button>
                          </div>
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
              <!--Change password tab -->
              <div class="card tab-pane {{ $errors->has('current-password') || $errors->has('new-password') || $errors->has('new-password_confirmation')  || Session::has('password') ? 'active' : '' }} " id="change-password">
                <div class="card-header">Change password</div>
                  <div class="card-body">
                   @if (session('error'))
                    <div class="alert alert-danger">
                      {{ session('error') }}
                    </div>
                   @endif
                   @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{route('changePassword')}}">
                       @csrf
                        <input type="hidden" name="password" value="password">
                        <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                            <label for="new-password" class="col-md-4 control-label">Current Password</label>
                            <div class="col-md-6">
                                <input id="current-password" type="password" class="form-control" name="current-password" required>
                                @if ($errors->has('current-password'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('current-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                            <label for="new-password" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="new-password" type="password" class="form-control" name="new-password" required>
                                <p><small>Password must be at least 8 characters.</small></p>
                                @if ($errors->has('new-password'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('new-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new-password-confirm" class="col-md-4 control-label">Confirm New Password</label>

                            <div class="col-md-6">
                                <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </form>
                  </div>
                </div>
          </div>
      </div>
  </div>
</div>

<script>
  function checkInput(){
    if(document.getElementById("name").value==="{{$user->name}}") { 
            document.getElementById('save-btn').disabled = true; 
        } else { 
            document.getElementById('save-btn').disabled = false;
        }
  }
</script>

@endsection
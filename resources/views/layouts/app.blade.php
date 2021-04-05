<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script>
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user' => Auth::user(),
            'signedIn' => Auth::check()
        ]) !!};
    </script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-touch-icon.png')}}">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   
</head>
<body>
      <div id="app">
        @include('layouts.nav')
        <main class="py-4">
            @yield('content')
        </main>
        <div class="flash-message alert-flash">
        </div>
        <div id="success-msg" class="alert-flash">
            @if( Session::has("message") )
            <div class="alert alert-success alert-block" role="alert">
            <button class="close" data-dismiss="alert"></button>
            {{ Session::get("message") }}
            </div>
            @endif
        </div>
        <div id="error-msg" class="alert-flash">
            @if( Session::has("error") )
            <div class="alert alert-danger alert-block" role="alert">
            <button class="close" data-dismiss="alert"></button>
            {{ Session::get("error") }}
            </div>
            @endif
        </div>
      </div>
      <script src="{{ asset('js/app.js') }}"></script>
      {{-- <script>
          Echo.channel('chat')
              .listen('Message', (e) => {
                console.log(e.message);
    });
      </script> --}}
</body>

<style>
    body{
            padding-bottom:100px;
        }
    .level{
            display: flex;
            align-items: center;
        }
    .flex{
            flex: 1;
        }

    .btn-width{
        min-width: 70px;
      }

    .alert-flash{
     position:fixed;
     right:25px;
     bottom:25px;
    }
    .navbar-bg-color{
        background-color: #2d2d2d;
    }
    .navbar-custom .dropdown-item:hover{  
         background-color: dimgray;
    }
    form.search-form input[type=text] {
        padding: 10px;
        font-size: 12px;
        border: 1px solid grey;
        border-radius: 25px 0 0 25px;
        float: left;
        width: 80%;
        background: #f1f1f1;
    }

    form.search-form input[type=text]:focus{
        outline: none;
    }

    form.search-form button {
        float: left;
        width: 20%;
        padding: 10px;
        background: #2196F3;
        color: white;
        font-size: 12px;
        border: 1px solid grey;
        border-radius: 0 25px 25px 0;
        border-left: none;
        cursor: pointer;
    }

    form.search-form button:hover {
     background: #0b7dda;
    }

    form.search-form::after {
        content: "";
        clear: both;
    display: table;
    }

@media(max-width:760px){
    .search-form{
        display: none;
    }
}

</style>

<script>
    
function hideSuccessMessage(){
            $('#success-msg').fadeOut(4000);
            $('#error-msg').fadeOut(4000);
        }
 
 setTimeout(hideSuccessMessage, 1000);

</script>


</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Forum Station</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

         <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('favicon/favicon-32x32.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-touch-icon.png')}}">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 50px;
                font-family: cursive;
                color: darkorange;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
         
            .background-img {
                background-image: url('images/landing_page_img/space.jpeg');
                background-repeat: no-repeat;
                background-size: 100%;
            }

            .button {
                color: black;
                border-radius: 50px;      
                text-decoration: none;
                margin-left: 40px;
                margin-right: 40px;
                font-size: 20px;
                display:inline-block;
                min-width: 100px;
             }

            .btn-gradient {
                background: rgb(250, 172, 24);
                background: linear-gradient(0deg,
                        rgba(250, 172, 24, 1) 5%,
                        rgba(255, 202, 5, 1) 56%,
                        rgba(255, 231, 163, 1) 94%);
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height background-img">
            <div class="content">
                <div class="title m-b-md">
                    Forum Station
                </div>
                <div class="container">                     
                    <div class="row mt-4">
                     <div class="col-12 col-md-6 offset-md-4 text-center">
                        @if (Route::has('login'))         
                        @auth
                         <a href="{{ url('/threads') }}" class="button btn-gradient"><b>Home</b></a>
                        @else
                         <a href="{{ route('login') }}" class="button btn-gradient"><b>Login</b></a>
                        @if (Route::has('register'))
                         <a href="{{ route('register') }}" class="button btn-gradient"><b>Register</b></a>
                        @endif
                        @endauth     
                        @endif
                     </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>



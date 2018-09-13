<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/mine.js"></script>
    
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #f1f1f1;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            #registroForm{
                background-color: #e3e7fd;
                margin-top: 5%;
                margin-right: 15%;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-light" style="background-color: #e3e7fd;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <center>
                    <ul class="navbar-nav pull-right">
                        @guest
                            <li class="nav-item btn pull-right" aria-label="Login">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/home') }}">Home</a>
                                    @else
                                        <!-- <a href="{{ route('login') }}">Login</a> -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Login</button> 
                                    @endauth
                                @endif
                            </li>
                        @else

                        @endguest
                    </ul>
                    </center>   
                </div>
            </div>
        </nav>

        <!-- Modal Login -->
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="well" style="margin:5%; background-color: #e3e7fd;" id="loginForm">
                        <center>
                            <h1>Welcome</h1>
                            <h3>Sign in</h3>
                        </center>
                        <form method="post" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                            <div class="form-group">
                                <label for="correoElectronico" >Email</label>
                                <input id="email" name="email" type="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="pass">Password</label>
                                <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                            </div>
                            <center>
                                <button type="submit" class="btn btn-primary" style="margin-top:10px;" align="center" id="iniciarSesion">{{ __('Login') }}</button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome image -->
        <div class="pull-left" style="margin-left:15%; margin-top:5%;">
            <img src="https://monash.it/files/news/workinprogressheader.png" width="640" height="346" style="opacity:.5">
        </div>

        <!-- Sign up -->
        <div class="well pull-right" id="registroForm">
            <center><h1>Sign Up</h1></center>
            <form method="post" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                <div class="form-group">
                    <label for="nombreUsuario" >Username</label>
                    <input id="name" name="name" type="text" class="form-control" placeholder="Username" required title="Complete this field" autofocus>
                </div>
                <div class="form-group">
                    <label for="correoElectronico" >Email</label>
                    <input id="email" name="email" type="email" class="form-control" placeholder="Email" required title="Complete this field">
                </div>
                <div class="form-group">
                    <label for="contrasenia">Password</label>
                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" required title="Complete this field">
                </div>
                <div class="form-group">
                    <label for="fechaNacimiento">Birthday</label>
                    <input name="fechaNacimiento" type="date" class="form-control" required title="Complete this field">
                </div>
                <div class="form-group">
                    <label for="genero">Sex</label>
                    <select name="genero">
                        <option value="1" selected="true">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Other</option>
                    </select>
                </div>
                <center>
                    <button type="submit" class="btn btn-primary" style="margin-top:10px;" align="center" id="registrarse">{{ __('Register') }}</button>
                </center>
            </form>
        </div>
    </body>
</html>

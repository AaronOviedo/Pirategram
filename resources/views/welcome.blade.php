<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- CSRF for Forms -->
        <meta name="csrf-token" content="{{{ csrf_token() }}}">

        <!-- Scripts -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/mine.js"></script>
    
        <!-- Styles -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/myStyles.css">

        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>
    <body>
        <nav class="navbar navbar-light" style="background-color: #e3e7fd;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <center>
                    <ul class="navbar-nav pull-right">
                        <li class="nav-item btn pull-right" aria-label="Login">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Login</button> 
                        </li>
                    </ul>
                    </center>   
                </div>
            </div>
        </nav>

        <!-- Modal Login -->
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="well morado"  id="loginForm">
                        <center>
                            <h1>Welcome</h1>
                            <h3>Sign in</h3>
                        </center>
                        <form method="get" action="/myUser">
                            <div class="form-group">
                                <label for="correoElectronico" >Email</label>
                                <input id="emailID" name="email" type="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="pass">Password</label>
                                <input id="passwordID" name="password" type="password" class="form-control" placeholder="Password" required>
                            </div>
                            <center>
                                <button type="submit" class="btn btn-primary moveDown" align="center" id="iniciarSesion">Login</button>
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
            <form method="post" action="/myUser" id="formRegister">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="nombreUsuario" >Username</label>
                    <input id="nameID" name="name" type="text" class="form-control" placeholder="Username" required title="Complete this field" autofocus>
                </div>
                <div class="form-group">
                    <label for="correoElectronico" >Email</label>
                    <input id="emailID" name="email" type="email" class="form-control" placeholder="Email" required title="Complete this field">
                </div>
                <div class="form-group">
                    <label for="contrasenia">Password</label>
                    <input id="passwordID" name="password" type="password" class="form-control" placeholder="Password" required title="Complete this field">
                </div>
                <div class="form-group">
                    <label for="fechaNacimiento">Birthday</label>
                    <input id="dateID" name="date" type="date" class="form-control" required title="Complete this field">
                </div>
                <div class="form-group">
                    <label for="genero">Sex</label>
                    <select name="gender" id="genderID">
                        <option value="1" selected="true">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Other</option>
                    </select>
                </div>
                <center>
                    <button type="submit" class="btn btn-primary moveDown" align="center">Register</button>
                </center>
            </form>
        </div>
    </body>
</html>

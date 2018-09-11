<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mine.js"></script>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <script type="text/javascript">

        $(document).ready(function(){
    
            $("#mostrarRegistro").click(function(){
    
                $("#loginForm").fadeOut("slow", function(){
                    $("#registroForm").fadeIn("slow");
                });
    
                document.getElementById("nombreUsuarioRegistro").focus();
    
                event.preventDefault();
            });
    
            $("#mostrarInicioSesion").click(function(){
    
                $("#registroForm").fadeOut("slow", function(){
                    $("#loginForm").fadeIn("slow");
                });
    
                document.getElementById("correoElectronicoRegistro").focus();			
    
                event.preventDefault();
            });
    
            $("#closeWarning").click(function(){
                $("#warningMessage").fadeOut("fast");
                event.preventDefault();
            });
    
        });
    
    </script>	

    <title>Pirategram</title>
</head>
<body>
    <body>

    <div class="well" style="max-width: 500px; margin: 100px auto 10px;" id="loginForm">
        <center>
            <h1>Welcome</h1>
            <h3>Sign in</h3>
        </center>
        <form method="post" action="login">
            <div class="form-group">
                <label for="correoElectronico" >Email</label>
                <input id="correoElectronico" name="correoElectronico" type="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="pass">Password</label>
                <input name="contrasenia" type="password" class="form-control" placeholder="Password" required>
            </div>
                <center>
                    <button type="submit" class="btn btn-primary" style="margin-top:10px;" align="center" id="iniciarSesion">Sign in</button>
                    <button type="button" class="btn btn-info" style="margin-top:10px;" align="center" id="mostrarRegistro">Sign up</button>
                </center>
        </form>
    </div>

    <!-- Registro a llevar en el inicio de sesion -->
	<div class="well" style="max-width: 500px; margin: 100px auto 10px; display: none" id="registroForm">
		<center><h1>Sign Up</h1></center>
		<form method="post" action="register" enctype="multipart/form-data">
			<div class="form-group">
				<label for="nombreUsuario" >Username</label>
				<input id="nombreUsuarioRegistro" name="nombreUsuario" type="text" class="form-control" placeholder="Username" required>
			</div>
           	<div class="form-group">
				<label for="correoElectronico" >Email</label>
                <input id="correoElectronicoRegistro" name="correoElectronico" type="email" class="form-control" placeholder="Email" required>
			</div>
			<div class="form-group">
				<label for="contrasenia">Password</label>
				<input name="contrasenia" type="contrasenia" class="form-control" placeholder="Password" required>
			</div>
                        <div class="form-group">
				<label for="fechaNacimiento">Bithday</label>
                <input name="fechaNacimiento" type="date" class="form-control" required>
			</div>
                        <div class="form-group">
				<label for="genero">Sex</label>
                                <select name="genero">
                                    <option value="1" selected="true">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Other</option>
                                </select>
			</div>
                        <div class="form-group">
                            <label for="descripcionUsuario" style="display: block;">User description</label>
                            <textarea style="width: 100%; height: 100px; border-radius: 5px;" id="descripcionUsuario" name="descripcionUsuario" placeholder="Speak us about you..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="imagenPerfil">Profile Picture</label>
                            <input type="file" id="imagenPerfil" name="imagenPerfil" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="imagenPortada">Cover Image</label>
                            <input type="file" id="imagenPortada" name="imagenPortada" class="form-control" required>
                        </div>
                        <center>
                            <button type="submit" class="btn btn-primary" style="margin-top:10px;" align="center" id="registrarse">Sign up</button>
                            <button type="button" class="btn btn-info" style="margin-top:10px;" align="center" id="mostrarInicioSesion">Sign in</button>
			</center>
		</form>
	</div>
</body>
</html>
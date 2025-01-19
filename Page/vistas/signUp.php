<?php
	include "/TP ENTORNOS/Page/inc/navbarUNR.php";
?>	

<!-- FUNCARÁ? -->
<head>

<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOVA</title>
    
    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>



<section id="about" class="about">
	<div class="container-fluid">
    
	<!-- SE MUESTRA EL RESULTADO DEL FORM CON ESTE DIV "form-rest" -->
		<!-- <div class="form-rest "></div> -->

			<div class="row">
				<div class="col-12">
					<form action="/TP ENTORNOS/Page/php/saveUser.php" method="POST" class="loginBox" autocomplete="off" >
						<br>
                        <br>  
                        <br>
                    	<h1>REGISTRO DE SESIÓN</h1>
                      	<br>
						<label>Email</label>
						<input class="form-control" type="email" name="nombreUsuario" placeholder="correo electronico" maxlength="70" required>
						<label>Clave</label>
						<input class="form-control" type="password" name="claveUsuario1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="contraseña" required>
						<label>Repetir clave</label>
						<input class="form-control" type="password" name="claveUsuario2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="Repita su contraseña" required>
						<p class="has-text-centered">
							<button type="submit" class="btn btn-primary" value="Ingresar">Registrar</button>
						</p>
						<a href="/TP ENTORNOS/Page/login.php">¿Ya tienes una cuenta? Inicia sesión</a>
					</form>	
				</div>	
			</div>
	</div>			
</section>


<?php
    include "/TP ENTORNOS/Page/inc/head.php";
    include "/TP ENTORNOS/Page/inc/script.php";
?>

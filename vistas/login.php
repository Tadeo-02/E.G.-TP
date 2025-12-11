<section id="about" class="about">
          <div class="container-fluid">
              <div class="row ">
                  <div class="col-12">
                    <form action="" method="POST" class="form" autocomplete="on" >
                        <br>
                        <br>  
                        <br>
                        <h1>INICIO DE SESIÓN</h1>
                        <br>
                        <label>Correo electrónico:</label>
                        <input class="form-control" type="email" name="nombreUsuario" placeholder="alguien@ejemplo.com" maxlength="70" required>
                        <label>Contraseña:</label>
                        <input class="form-control" type="password" name="claveUsuario" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="********" required>
                        <p class="has-text-centered">
                            <br>    
                            <button type="submit" class="btn btn-primary" value="Ingresar" href="">Confirmar</button>
                            <br>
                            <br>
                            <a href="index.php?vista=signUp">Crear Cuenta</a>
                        </p>

                        <!-- Identifica si enviamos el formulario -->
                        <?php
                            if(isset($_POST['nombreUsuario']) && isset($_POST['claveUsuario'])){ 
                                // si esto sucede traemos el main con la conexion a la db (y mas funciones)
                                require_once "./php/main.php";
                                require_once "./php/loginUser.php";
                            }
                        ?>

                    </form>
                  </div>
              </div>
          </div>
</section>
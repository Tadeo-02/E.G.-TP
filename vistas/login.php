<section id="about" class="about">
          <div class="container-fluid">
              <div class="row ">
                  <div class="col-12">
                    <form action="" method="POST" class="form" autocomplete="on" style="padding: 20px;">
                        <h1 class="text-center">INICIO DE SESIÓN</h1>

                        <div class="mb-3">
                            <label for="nombreUsuarioLogin">Correo electrónico:</label>
                            <input id="nombreUsuarioLogin" class="form-control" type="email" name="nombreUsuario" placeholder="alguien@ejemplo.com" maxlength="70" required aria-describedby="emailLoginHelp">
                            <small id="emailLoginHelp" class="form-text text-muted" style="margin-top: 5px;">Introduce un correo válido.</small>
                        </div>

                        <div class="mb-3">
                            <label for="claveUsuarioLogin">Contraseña:</label>
                            <input id="claveUsuarioLogin" class="form-control" type="password" name="claveUsuario" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="********" required aria-describedby="passwordLoginHelp">
                            <small id="passwordLoginHelp" class="form-text text-muted" style="margin-top: 5px;">La contraseña debe tener al menos 7 caracteres.</small>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" value="Ingresar" href="">Confirmar</button>
                            <p style="margin-top: 15px;">
                                <a href="index.php?vista=signUp" aria-label="Crear una nueva cuenta">Crear Cuenta</a>
                            </p>
                        </div>

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
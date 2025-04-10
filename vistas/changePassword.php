<section id="about" class="about">
          <div class="container-fluid">
              <div class="row ">
                  <div class="col-12">
                    <form action="/TP ENTORNOS/php/cambiarContraseña.php" method="POST" class="form" autocomplete="on" >
                        <br>
                        <br>  
                        <br>
                        <h1>CAMBIAR CONTRASEÑA</h1>
                        <br>
                        <label>Email</label>
						<input class="form-control" type="email" name="nombreUsuario" placeholder="alguien@ejemplo.com" maxlength="70" required>
                        <label>Contraseña:</label>
                        <input class="form-control" type="password" name="claveUsuario1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="********" required>
                        <label>Repita la contraseña:</label>
                        <input class="form-control" type="password" name="claveUsuario2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" placeholder="********" required>
                        <p class="has-text-centered">
                            <br>    
                            <button type="submit" class="btn btn-primary" value="Ingresar" href="login.php">Confirmar</button>
                            <br>
                            <br>
                            <a href="/TP ENTORNOS/index.php?vista=login">Iniciar sesión</a>
                        </p>
                    </form>
                  </div>
              </div>
          </div>
</section>
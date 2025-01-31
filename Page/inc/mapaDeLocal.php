<section id="about" class="about section-padding">
          <div class="container">
              <div class="row">
                  <div class="col-lg-4 col-md-12 col-12">
                      <div class="about-img">
                          <img src="img/about.jpg" alt="" class="img-fluid">
                      </div>
                  </div>
                  <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
                      <div class="about-text">
                            <h2>MAPA DEL LOCAL</h2>
                            <ul class="has-text-centered">
                                <li><a class="nav-link" href="#">Inicio</a></li>
                                
                                <?php
                                if((!isset($_SESSION['codUsuario']) || $_SESSION['codUsuario']=="") || (!isset($_SESSION['nombreUsuario']) || $_SESSION['nombreUsuario']=="")){
                                    echo '<li class="nav-item">
                                            <a class="nav-link" href="/TP ENTORNOS/Page/vistas/localsList.php?page=">LOCALES</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link" href="#cualquieragordo">PROMOCIONES</a>
                                        </li>
                                        
                                        ';
                                } else{
                                    if($_SESSION['tipoUsuario']=="Administrador"){
                                        echo '<li class="nav-item">
                                            <a class="nav-link" href="login.php">Gestionar Local</a>
                                            </li>    
                                            <li class="nav-item">
                                                <a class="nav-link" href="login.php">Gestionar Novedades</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="login.php">Utilizacion de Descuentos</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="login.php">Solicitudes de Descuento</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="login.php">Solicitud de cuenta de Dueño</a>
                                            </li>
                                            ';
                                    } else {
                                        if($_SESSION['tipoUsuario']=="Cliente") {
                                            echo '<li class="nav-item">
                                                    <a class="nav-link" href="/TP ENTORNOS/Page/vistas/localsList.php?page=">LOCALES</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="home.php#about">Novedades</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="home.php#about">Descuentos</a>
                                                </li>
                                               ';    
                                        } else {
                                                echo '<li class="nav-item">
                                                        <a class="nav-link" href="locales.php"> Mis Locales</a>
                                                    </li> 
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="login.php">Crear Local</a>
                                                    </li>     
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="login.php">Eliminar Local</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#cualquieragordo">Mis Promociones</a>
                                                    </li> 
                                                     <li class="nav-item">
                                                        <a class="nav-link" href="/TP ENTORNOS/Page/index.php?vista=cargaPromociones">Ingresar Promociones</a>
                                                    </li> 
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="login.php">Solicitudes de Descuento</a>
                                                    </li>  
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="login.php">Usos de Descuento</a>
                                                    </li>     
                                                    ';        
                                        };
                                    };
                                };
                            ?> 
                            </ul>
                            <a href="#" class="btn btn-warning">Learn More</a>
                      </div>
                  </div>
              </div>
          </div>
</section>
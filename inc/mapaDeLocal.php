<section id="about" class="about section-padding">
          <div class="container">
              <div class="row">
                  <div class="col-lg-4 col-md-12 col-12">
                      <div class="about-img">
                          <img src="img/about.jpg" alt="Mapa del centro comercial Nova mostrando la distribución de locales" class="img-fluid">
                      </div>
                  </div>
                  <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
                      <div class="about-text">
                            <h2>MAPA DEL SITIO</h2>
                            <ul class="has-text-centered">
                                <li><a class="nav-link" href="#">Inicio</a></li>
                                
                                <?php
                                if((!isset($_SESSION['codUsuario']) || $_SESSION['codUsuario']=="") || (!isset($_SESSION['nombreUsuario']) || $_SESSION['nombreUsuario']=="")){
                                    echo '<li class="nav-item">
                                             <a class="nav-link" href="index.php?vista=localsList">LOCALES</a>
                                        </li>  
                                        <li class="nav-item">
                                            <a class="nav-link" href="index.php?vista=promocionesList">PROMOCIONES</a>
                                        </li>
                                        
                                        ';
                                } else{
                                    if($_SESSION['tipoUsuario']=="Administrador"){
                                        echo '<li class="nav-item">
                                            <a class="nav-link" href="index.php?vista=localsList">Gestionar Local</a>
                                            </li>    
                                            <li class="nav-item">
                                                <a class="nav-link" href="index.php?vista=novedadesList">Gestionar Novedades</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="index.php?vista=discountReport">Utilizacion de Descuentos</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="index.php?vista=promocionesList">Solicitudes de Descuento</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="index.php?vista=ownerAccountRequest">Solicitud de cuenta de Dueño</a>
                                            </li>
                                            ';
                                    } else {
                                        if($_SESSION['tipoUsuario']=="Cliente") {
                                            echo '<li class="nav-item">
                                                    <a class="nav-link" href="index.php?vista=localsList">LOCALES</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="index.php?vista=novedadesList">Novedades</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="index.php?vista=promocionesList">Descuentos</a>
                                                </li>
                                               ';    
                                        } else {
                                                echo '<li class="nav-item">
                                                        <a class="nav-link" href="index.php?vista=localsList"> Mis Locales</a>
                                                    </li> 
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="index.php?vista=promocionesList">Mis Promociones</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="index.php?vista=discountRequest">Solicitudes de Descuento</a>
                                                    </li>  
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="index.php?vista=discountReportlogin.php">Usos de Descuento</a>
                                                    </li>     
                                                    ';        
                                        };
                                    };
                                };
                            ?> 
                            </ul>
                    
                      </div>
                  </div>
              </div>
          </div>
</section>
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/TP ENTORNOS/PAGE/index.php"><span class="text-warning">NO</span>VA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="/TP ENTORNOS/Page/index.php?vista=home">INICIO</a>
            </li>
<?php
    if((!isset($_SESSION['codUsuario']) || $_SESSION['codUsuario']=="") || (!isset($_SESSION['nombreUsuario']) || $_SESSION['nombreUsuario']=="")){
        echo '<li class="nav-item">
                <a class="nav-link" href="/TP ENTORNOS/Page/index.php?vista=localsList">LOCALES</a>
            </li>  
            <li class="nav-item">
                <a class="nav-link" href="/TP ENTORNOS/Page/index.php?vista=promocionesList">PROMOCIONES</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/TP ENTORNOS/Page/index.php#about">MAPA DEL SITIO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/TP ENTORNOS/Page/index.php?vista=login">INICIAR SESIÓN</a>
            </li>';
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
                <li class="nav-item">
                    <a class="nav-link" href="/TP ENTORNOS/Page/index.php#about">MAPA DEL SITIO</a>
                </li>
               <li class="nav-item">
                    <a class="nav-link" href="/TP ENTORNOS/Page/index.php?vista=logout">SALIR</a>
                </li>
               <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Usuario</a>
                    <ul class="dropdown-menu">
                        <li> <p class="dropdown-item"> ' .htmlspecialchars($_SESSION['tipoUsuario']).   '       </p> </li>
                        <li><p class="dropdown-item">       ' .htmlspecialchars($_SESSION['nombreUsuario']).   '       </p></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/TP ENTORNOS/Page/index.php?vista=logout">SALIR</a></li>
                    </ul>
                </li>';
        } else {
            if($_SESSION['tipoUsuario']=="Cliente") {
                echo '<li class="nav-item">
                        <a class="nav-link" href="/TP ENTORNOS/Page/index.php?vista=localsList">LOCALES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php#about">Novedades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php#about">Descuentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/TP ENTORNOS/Page/index.php#about">MAPA DEL SITIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/TP ENTORNOS/Page/index.php?vista=logout">SALIR</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Usuario</a>
                        <ul class="dropdown-menu">
                            <li> <p class="dropdown-item"> ' .htmlspecialchars($_SESSION['tipoUsuario']).   '       </p> </li>
                            <li><p class="dropdown-item">       ' .htmlspecialchars($_SESSION['nombreUsuario']).   '       </p></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/TP ENTORNOS/Page/index.php?vista=logout">SALIR</a></li>
                        </ul>
                    </li>';    
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
                        <li class="nav-item">
                            <a class="nav-link" href="/TP ENTORNOS/Page/index.php#about">MAPA DEL SITIO</a>
                        </li>
                        <li class="nav-item">
                            
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Usuario</a>
                            <ul class="dropdown-menu">
                                <li> <p class="dropdown-item"> ' .htmlspecialchars($_SESSION['tipoUsuario']).   '       </p> </li>
                                <li><p class="dropdown-item">       ' .htmlspecialchars($_SESSION['nombreUsuario']).   '       </p></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/TP ENTORNOS/Page/index.php?vista=logout">SALIR</a></li>
                            </ul>
                        </li>';        
            };
        };
    };
?> 
        </ul>
        </div>
    </div>
</nav>

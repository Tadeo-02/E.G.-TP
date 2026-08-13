<?php

require_once __DIR__ . '/config.php';

// Iniciar sesión con el mismo nombre usado en la aplicación
function iniciarSesion() {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_name("UNR");
        session_start();
    }
}

// conexion a la base de datos
function conexion(){ 
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Problemas de conexion a la base de datos");
    mysqli_set_charset($link, "utf8mb4");
    return $link;
}

// Verficiar datos (aplicar a forms)
function verificarDatos($filtro, $str){ //Filtro es la expresion regular y luego el str que queremos verificar que coincida con el filtro/expresion regular
    if(preg_match("/^".$filtro."$/", $str)){
        return false; // si el texto coincide no hay ningun error
    }else{
        return true; // si el str no coincide, hay error
    }
}

// Limpiar cadenas de texto 
function limpiar_cadena ($cadena){
    if($cadena === null || $cadena === '') {
        return '';
    }
    $cadena=trim($cadena);
    $cadena=stripslashes($cadena);
    $cadena=str_ireplace("<script>", "", $cadena);
    $cadena=str_ireplace("</script>", "", $cadena);
    $cadena=str_ireplace("<script src", "", $cadena);
    $cadena=str_ireplace("<script type=", "", $cadena);
    $cadena=str_ireplace("SELECT * FROM", "", $cadena);
    $cadena=str_ireplace("DELETE FROM", "", $cadena);
    $cadena=str_ireplace("INSERT INTO", "", $cadena);
    $cadena=str_ireplace("DROP TABLE", "", $cadena);
    $cadena=str_ireplace("DROP DATABASE", "", $cadena);
    $cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
    $cadena=str_ireplace("SHOW TABLES;", "", $cadena);
    $cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
    $cadena=str_ireplace("<?php", "", $cadena);
    $cadena=str_ireplace("?>", "", $cadena);
    $cadena=str_ireplace("--", "", $cadena);
    $cadena=str_ireplace("^", "", $cadena);
    $cadena=str_ireplace("<", "", $cadena);
    $cadena=str_ireplace("[", "", $cadena);
    $cadena=str_ireplace("]", "", $cadena);
    $cadena=str_ireplace("==", "", $cadena);
    $cadena=str_ireplace(";", "", $cadena);
    $cadena=str_ireplace("::", "", $cadena);
    $cadena=trim($cadena);
    $cadena=stripslashes($cadena);
    return $cadena;
}

// Redireccion segura validando que sea al mismo host
function redirigirSeguro($url, $fallback = 'index.php') {
    if ($url === '' || $url === null) {
        header("Location: $fallback");
        exit();
    }
    $hostPropio = $_SERVER['HTTP_HOST'] ?? '';
    $componentes = parse_url($url);
    if (isset($componentes['host']) && $componentes['host'] !== $hostPropio) {
        header("Location: $fallback");
        exit();
    }
    header("Location: $url");
    exit();
}

// Funcion renombrar fotos
function renombrar_fotos($nombre){
    $nombre=str_ireplace(" ", "_", $nombre);
    $nombre=str_ireplace("/", "_", $nombre);
    $nombre=str_ireplace("#", "_", $nombre);
    $nombre=str_ireplace("-", "_", $nombre);
    $nombre=str_ireplace("$", "_", $nombre);
    $nombre=str_ireplace(".", "_", $nombre);
    $nombre=str_ireplace(",", "_", $nombre);
    $nombre=$nombre."_".rand(0,100);
    return $nombre;
}

// Funcion paginador de tablas
function paginador_tablas($pagina, $Npaginas, $url, $botones) {
    $tabla = '
                <nav aria-label="Paginación de resultados">
                <ul class="pagination justify-content-center">';

    // Botón "Anterior"
    if ($pagina <= 1) {
        $tabla .= '<li class="page-item disabled">
                    <span class="d-none d-sm-block">
                        <a class="page-link" tabindex="-1" aria-disabled="true">Anterior</a>
                    </span>
                    <span class="d-block d-sm-none">
                        <a class="page-link" tabindex="-1" aria-disabled="true"><</a>
                    </span>
                </li>';
    } else {
        $tabla .= '<li class="page-item">
                    <span class="d-none d-sm-block">
                        <a class="page-link" href="' . $url . ($pagina - 1) . '">Anterior</a>
                    </span>
                    <span class="d-block d-sm-none">
                        <a class="page-link" href="' . $url . ($pagina - 1) . '"><</a>
                    </span>
                </li>';
    }

    $ci = 0;

    // Números de página antes del actual
    if ($pagina > 1) {
        if(($pagina-1)!=1){
            $tabla .= '<li class="page-item">
                <a class="page-link" href="' . $url . '1">1</a>
            </li>';
            if(($pagina-2)!=1){
                $tabla .= '<li class="page-item disabled">
                    <span class="page-link">&hellip;</span>
                </li>';
            }
        };
        $tabla .= '<li class="page-item">
            <a class="page-link" href="' . $url . ($pagina-1).'">'. ($pagina-1).'</a>
        </li>';
    }

    // Números de página cercanos
    for ($i = $pagina; $i <= $Npaginas; $i++) {
        if ($ci >= $botones) {
            break;
        }
        if ($pagina == $i) {
            $tabla .= '<li class="page-item active">
                        <a class="page-link" href="' . $url . $i . '">' . $i . '</a>
                    </li>';
        }
        $ci++;
    }

    // Números de página después del actual
    if ($pagina < $Npaginas) {
        $tabla .= '<li class="page-item">
            <a class="page-link" href="' . $url . ($pagina+1).'">'. ($pagina+1).'</a>
        </li>';
        if(($pagina+1)!=$Npaginas){
            if(($pagina+2)!=$Npaginas){
                $tabla .= '<li class="page-item disabled">
                    <span class="page-link">&hellip;</span>
                </li>';
            }
            $tabla .= '<li class="page-item">
                <a class="page-link" href="' . $url . $Npaginas . '">' . $Npaginas . '</a>
            </li>';
        }

    }

    // Botón "Siguiente"
    if ($pagina == $Npaginas) {
        $tabla .= '<li class="page-item disabled">
                    <span class="d-none d-sm-block">
                        <a class="page-link" tabindex="-1" aria-disabled="true">Siguiente</a>
                    </span>
                    <span class="d-block d-sm-none">
                        <a class="page-link" tabindex="-1" aria-disabled="true">></a>
                    </span>
                </li>';
    } else {
        $tabla .= '<li class="page-item">
                    <span class="d-none d-sm-block">
                        <a class="page-link" href="'. $url . ($pagina + 1) .'">Siguiente</a>
                    </span>
                    <span class="d-block d-sm-none">
                        <a class="page-link" href="'. $url . ($pagina + 1) .'">></a>
                    </span>
                </li>';
    }

    $tabla .= '</ul>
            </nav>
            ';

    return $tabla;
}

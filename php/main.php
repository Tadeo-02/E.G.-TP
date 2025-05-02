<?php
// conexion a la base de datos
function conexion(){ 
    $link = mysqli_connect("mysql", "root", "pw") or die("Problemas de conexion a la base de datos");
    mysqli_select_db($link, "tp entornos");
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
                <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">';

    // Botón "Anterior"
    if ($pagina <= 1) {
        $tabla .= '<li class="page-item disabled">
                    <span class="d-none d-sm-block">
                        <a class="page-link" href="#" aria-label="Anterior">Anterior</a>
                    </span>
                    <span class="d-block d-sm-none">
                        <a class="page-link" href="#" aria-label="Anterior"><</a>
                    </span>
                </li>';
    } else {
        $tabla .= '<li class="page-item">
                    <span class="d-none d-sm-block">
                        <a class="page-link" href="' . $url . ($pagina - 1) . '" aria-label="Anterior">Anterior</a>
                    </span>
                    <span class="d-block d-sm-none">
                        <a class="page-link" href="' . $url . ($pagina - 1) . '" aria-label="Anterior"><</a>
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
                        <a class="page-link" href="#"  tabindex="-1">Siguiente</a>
                    </span>
                    <span class="d-block d-sm-none">
                        <a class="page-link" href="#"  tabindex="-1">></a>
                    </span>
                </li>';
    } else {
        $tabla .= '<li class="page-item">
                    <span class="d-none d-sm-block">
                        <a class="page-link" href="'. $url . ($pagina + 1) .'"  tabindex="-1">Siguiente</a>
                    </span>
                    <span class="d-block d-sm-none">
                        <a class="page-link" href="'. $url . ($pagina + 1) .'"  tabindex="-1">></a>
                    </span>
                </li>';
    }

    $tabla .= '</ul>
            </nav>
            ';

    return $tabla;
}

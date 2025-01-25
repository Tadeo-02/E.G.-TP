<?php
    $modulo_buscador=limpiar_cadena($_POST['modulo_buscador']);
    $modulos=["locales"]; //lista de todos los modulos que tenemos

    if(in_array($modulo_buscador,$modulos)){
        if($modulo_buscador=="locales"){
            $txt_buscador=limpiar_cadena($_POST['txt_buscador']);
            $_SESSION['busquedaLocal']=$txt_buscador;
            header("Location: ../vistas/localsSearch.php");
        }

    }else{
        echo '<div class="alert alert-danger" role="alert">
                    No podemos procesar la búsqueda
                      </div>';
    }


?>
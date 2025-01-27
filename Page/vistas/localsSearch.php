<div class="container-fluid mb-3">
    <h1 class="display-4">Usuarios</h1>
    <h2 class="h5 text-muted">Buscar usuario</h2>
</div>
<?php
    require_once(__DIR__ . '/../php/main.php');

    if(isset($_POST['modulo_buscador'])) {
        require_once (__DIR__ . '/../php/buscador.php');
    }

    if(!isset($_SESSION['busquedaLocal']) && empty($_SESSION['busquedaLocal'])){
        $_SESSION['busquedaLocal'];
    
?>
        <div class="container py-4">

            <div class="row mb-4">
                <div class="col-12">
                    <form action="" method="POST" autocomplete="off">
                        <input type="hidden" name="modulo_buscador" value="locales">
                        <div class="input-group">
                            <input 
                                type="text" 
                                name="txt_buscador" 
                                class="form-control rounded-pill" 
                                placeholder="¿Qué estas buscando?" 
                                pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}"
                                maxlength="30">
                            <button type="submit" class="btn btn-info rounded-pill">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
<?php

}else{

?>


    <div class="row">
        <div class="col-12 text-center">
            <form action="" method="POST" autocomplete="off">
                <input type="hidden" name="modulo_buscador" value="locales">
                <input type="hidden" name="eliminar_buscador" value="locales">
                <p>Estas buscando <strong>
                    <?php
                        echo $_SESSION['busquedaLocal'];
                    ?>
                </strong></p>
                <button type="submit" class="btn btn-danger rounded-pill mt-3">Eliminar búsqueda</button>
            </form>
        </div>
    </div>
<?php

    if(!isset($_GET['page'])){
        $pagina=1;
    }else{
        $pagina=(int) $_GET['page'];
        if($pagina<=1){
            $pagina=1;
        }
    }

    $pagina=limpiar_cadena($pagina);
    $url="/TP ENTORNOS/Page/vistas/localsSearch.php?page="; //& en lugar de ?
    $registros=1;
    $busqueda=$_SESSION['busquedaLocal'];

    # Paginador locales #
    require_once (__DIR__. '/../php/listaLocales.php');

    }
?>

</div>

<div class="container-fluid mb-3">
    <h1 class="display-4">Usuarios</h1>
    <h2 class="h5 text-muted">Buscar usuario</h2>
</div>
<?php
    require_once ".php/main.php";

    if(isset($_POST['modulo_buscador'])) {
        require_once ".php/buscador.php";


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

    include "../inc/form.php";
    include "../inc/footer.php";
    }
?>

    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped table-hover text-center">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>usuario_nombre</td>
                    <td>usuario_apellido</td>
                    <td>usuario_usuario</td>
                    <td>usuario_email</td>
                    <td>
                        <a href="#" class="btn btn-success btn-sm rounded-pill">Actualizar</a>
                    </td>
                    <td>
                        <a href="#" class="btn btn-danger btn-sm rounded-pill">Eliminar</a>
                    </td>
                </tr>

                <tr>
                    <td colspan="7">
                        <a href="#" class="btn btn-link text-decoration-none mt-3 mb-3">Haga clic acá para recargar el listado</a>
                    </td>
                </tr>

                <tr>
                    <td colspan="7">No hay registros en el sistema</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="text-end">
        <p>Mostrando usuarios <strong>1</strong> al <strong>9</strong> de un <strong>total de 9</strong></p>
    </div>

    <nav aria-label="Paginación" class="d-flex justify-content-center">
        <ul class="pagination pagination-rounded">
            <li class="page-item">
                <a class="page-link" href="#">Anterior</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
            <li class="page-item active" aria-current="page"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item disabled"><span class="page-link">&hellip;</span></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Siguiente</a>
            </li>
        </ul>
    </nav>
    <?php
    
    ?>

</div>

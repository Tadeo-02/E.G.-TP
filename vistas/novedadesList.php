<?php
    // Verificar que el usuario esté logueado
    if(!isset($_SESSION['codUsuario']) || $_SESSION['codUsuario']==""){
        header("Location: index.php?vista=login");
        exit();
    }
?>

<div class="container-fluid p-0">
</div>

<div class="row g-0">
    <?php
        require_once(__DIR__ . '/../php/main.php');
    ?>
    <div class="container centered" style="align-items: center; flex-direction: column; padding: 10px;">
        <br>
        <br>
        <br>
        <h1 class="text-center" style="color: white"><b>NOVEDADES</b></h1>
        <br>
        
        <!-- BOTON CREAR NOVEDADES, SOLO LO VE EL ADMIN -->
        <?php if (isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario'] == "Administrador") { ?>
            <div class="col-lg-3 mb-3 botonCrearNovedad">
                <form action="index.php?vista=cargaNovedad" method="POST">
                    <div class="">
                        <input type="submit" name="" class="btn btn-success crear" value="Crear Novedad"> 
                    </div>
                </form>
        </div>
        <?php } ?>

        <div class="container">
            <?php
                if(!isset($_GET['page'])){
                    $pagina=1;
                }else{
                    $pagina=(int) $_GET['page'];
                    if($pagina<=1){
                        $pagina=1;
                    }
                };

                $pagina=limpiar_cadena($pagina);
                $url="index.php?vista=novedadesList&page=";
                $registros = 1;

                require_once (__DIR__. '/../php/listaNovedades.php');
            ?>
        </div>
    </div>
</div>

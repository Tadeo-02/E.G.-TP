<div class="container-fluid p-0">
    <h1 class="title">Novedades</h1>
</div>

<div class="row g-0">
    <?php
        require_once(__DIR__ . '/../php/main.php');
    ?>
    <div class="container widht">
        <br>
        <br>
        <br>
        <h1 class="text-center" style="color: white"><b>NOVEDADES</b></h1>
        <br>

        <?php if (isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario'] == "Administrador") { ?>
        <div class="col-lg- mb-3 botonNovedad">
            <form action="index.php?vista=cargaNovedad" method="POST">
                    <input type="submit" name="" class="btn btn-success crear" value="Crear Novedad">  
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

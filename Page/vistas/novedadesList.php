<div class="container-fluid p-0">
    <h1 class="title">Novedades</h1>
</div>

<div class="row g-0">
    <?php
        require_once(__DIR__ . '/../php/main.php');
    ?>
    <div class="container g-0">
        <br>
        <br>
        <br>
        <h1 class="text-center" style="color: white"><b>NOVEDADES</b></h1>
        <br>
       

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
                // $busqueda = (isset( $_SESSION['busquedaLocal'])) ? $_SESSION['busquedaLocal'] : '';

                require_once (__DIR__. '/../php/listaNovedades.php');

            ?>
        </div>
    </div>
</div>




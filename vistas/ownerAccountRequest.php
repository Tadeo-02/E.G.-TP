<div class="container-fluid p-0">
    <h1 class="title">Solicitud de Cuenta de Dueño</h1>
</div>

<div class="row g-0">
    <?php
        require_once(__DIR__ . '/../php/main.php');
    ?>
    <div class="container">
        <br>
        <br>
        <br>
        <h1 class="text-center" style="color: white"><b>SOLICITUDES DE CUENTA</b></h1>
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
                $url="index.php?vista=ownerAccountRequest&page=";
                $registros = 10;

                require_once (__DIR__. '/../php/admin/solicitudCuentaDueño.php');

            ?>
        </div>
    </div>
</div>

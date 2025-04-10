<div class="container-fluid p-0">
    <h1 class="title">Solicitudes de Descuento</h1>
</div>

<div class="row g-0">
    <?php
        require_once(__DIR__ . '/../php/main.php');
    ?>
    <div class="container">
        <br>
        <br>
        <br>
        <h1 class="text-center" style="color: white"><b>SOLICITUDES DE DESCUENTO</b></h1>
        <br>
        <div class="col md-4 lg-10">
                <div class="container">
                    <?php
                        $ordenar = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'codUso';

                        if(!isset($_GET['page'])){
                            $pagina=1;
                        }else{
                            $pagina=(int) $_GET['page'];
                            if($pagina<=1){
                                $pagina=1;
                            }
                        };

                        $pagina=limpiar_cadena($pagina);
                        $url="index.php?vista=discountRequest&sortBy=$ordenar&page="; 
                        $registros=9;

                        require_once (__DIR__. '/../php/dueñoLocal/listaSolicitudDescuentos.php');

                    ?>
                </div>
            
        </div>
    </div>
</div>




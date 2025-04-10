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
        <h1 class="text-center" style="color: white"><b>REPORTE DE UTILIZACION DE DESCUENTOS</b></h1>
      
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
                        $url="index.php?vista=discountReport&sortBy=$ordenar&page="; 
                        $registros=15;

                        require_once (__DIR__. '/../php/dueñoLocal/reporteDescuento.php');

                    ?>
                </div>
            
    </div>
</div>




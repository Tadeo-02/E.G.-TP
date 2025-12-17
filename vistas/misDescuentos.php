<?php
    require_once(__DIR__ . '/../php/main.php');
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    // Mostrar mensaje si existe
    if (isset($_SESSION['mensaje'])) {
        echo '<div class="container" style="margin-top: 80px; position: relative; z-index: 1000;">'
            . '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
            . htmlspecialchars($_SESSION['mensaje'])
            . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            . '</div>'
            . '</div>';
        unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
    }

    // Recoger parámetros
    $ordenar = isset($_GET['sortBy']) ? $_GET['sortBy'] : '';

    if(!isset($_GET['page'])){
        $pagina=1;
    }else{
        $pagina=(int) $_GET['page'];
        if($pagina<=1){
            $pagina=1;
        }
    };
    $pagina=limpiar_cadena($pagina);

    $url="index.php?vista=misDescuentos&sortBy=$ordenar&page=";
    $registros=5;
?>

<div class="container mt-3">
    <br>
    <br>
    <br>
    <h1 class="text-center" style="color: white"><b>MIS DESCUENTOS</b></h1>
    <br>

    <div class="centered row mb-4">
        <form action="index.php" id="sortForm" method="get" class="col-lg-5 col-md-5 col-12 d-flex justify-content-center">
            <input type="hidden" name="vista" value="misDescuentos">
            <select class="form-select" name="sortBy" aria-label="Seleccionar orden" onchange="this.form.submit()">
                <option value="" disabled <?php echo $ordenar == '' ? 'selected' : ''; ?>>Ordenar por</option>
                <option value="up.fechaUsoPromo" <?php echo $ordenar == 'up.fechaUsoPromo' ? 'selected' : ''; ?>>Fecha solicitud</option>
                <option value="l.nombreLocal" <?php echo $ordenar == 'l.nombreLocal' ? 'selected' : ''; ?>>Local</option>
                <option value="p.codPromo" <?php echo $ordenar == 'p.codPromo' ? 'selected' : ''; ?>>ID promoción</option>
                <option value="p.fechaDesdePromo" <?php echo $ordenar == 'p.fechaDesdePromo' ? 'selected' : ''; ?>>Válido desde</option>
                <option value="p.fechaHastaPromo" <?php echo $ordenar == 'p.fechaHastaPromo' ? 'selected' : ''; ?>>Válido hasta</option>
            </select>
        </form>
    </div>

    <?php
        require_once (__DIR__. '/../php/cliente/listaMisDescuentos.php');
    ?>
</div>

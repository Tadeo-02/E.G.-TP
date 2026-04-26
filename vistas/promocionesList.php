<?php
require_once(__DIR__ . '/../php/main.php');

// Iniciar sesión con el mismo nombre usado en la aplicación
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name("UNR");
    session_start();
}

// Mostrar mensaje si existe - EXACTAMENTE como en cargaPromociones.php
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    
    // Determinar color: verde para éxito, rojo para errores
    if (strpos($mensaje, 'éxito') !== false || strpos($mensaje, 'registrada') !== false || strpos($mensaje, 'correctamente') !== false) {
        echo '<div class="container" style="margin-top: 80px; position: relative; z-index: 9999;">'
            . '<div class="alert alert-success alert-dismissible fade show" role="alert">'
            . htmlspecialchars($mensaje)
            . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            . '</div>'
            . '</div>';
    } else {
        echo '<div class="container" style="margin-top: 80px; position: relative; z-index: 9999;">'
            . '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
            . htmlspecialchars($mensaje)
            . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
            . '</div>'
            . '</div>';
    }
    unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
}
?>

<div class="container-fluid p-0">
</div>

<div class="row g-0">
    <div class="container list-page">
        <br>
        <br>
        <br>
        <h1 class="text-center" style="color: white"><b>PROMOCIONES</b></h1>
        <br>
        
        <?php
            // Establecer conexión
            $conexion = conexion();

            // Consulta para obtener las promociones
            $consulta_filtro = "SELECT * FROM promociones";
            $promociones = mysqli_query($conexion, $consulta_filtro);

            // Obtener el dia actual de la URL (si está presente)
            $diaDesdeActual = isset($_GET['diaDesde']) ? $_GET['diaDesde'] : '';
            $diaHastaActual = isset($_GET['diaHasta']) ? $_GET['diaHasta'] : '';
            $localActual = isset($_GET['codLocal']) ? $_GET['codLocal'] : '';

            $tipoUsuario = isset($_SESSION['tipoUsuario']) ? $_SESSION['tipoUsuario'] : '';
            $sortActual = isset ($_GET['sortBy']) ? $_GET['sortBy'] : '';
            $orderActual = isset($_GET['order']) ? $_GET['order'] : 'ASC';
        ?>
        <div class="row g-4">
            <aside class="col-lg-3 col-md-4 mb-4 mb-md-0">
                <?php if($tipoUsuario == "Dueño") { ?>
                    <div class="filters-side-action">
                        <form action="index.php?vista=cargaPromociones" method="post">
                            <div class="botonCrear">
                                <input type="submit" class="btn btn-success crear" value="Crear Promoción">
                            </div>
                        </form>
                    </div>
                <?php } ?>

                <section class="filters-panel" aria-labelledby="filters-title-promos">
                    <h2 id="filters-title-promos" class="filters-title">Filtros</h2>

                    <form action="index.php" method="get" id="promoFiltersForm" class="filters-group">
                        <input type="hidden" name="vista" value="promocionesList">
                        <input type="hidden" name="order" value="<?php echo htmlspecialchars($orderActual); ?>">
                        <?php if ($localActual !== '') { ?>
                            <input type="hidden" name="codLocal" value="<?php echo htmlspecialchars($localActual); ?>">
                        <?php } ?>
                        <div class="filters-field">
                            <label for="diaDesde" class="form-label">Fecha inicio</label>
                            <input type="date" id="diaDesde" name="diaDesde" class="form-control" min="2000-01-01" max="2099-12-31" value="<?php echo htmlspecialchars($diaDesdeActual); ?>">
                        </div>
                        <div class="filters-field">
                            <label for="diaHasta" class="form-label">Fecha final</label>
                            <input type="date" id="diaHasta" name="diaHasta" class="form-control" min="2000-01-01" max="2099-12-31" value="<?php echo htmlspecialchars($diaHastaActual); ?>">
                        </div>
                        <div class="filters-field">
                            <label for="sortByPromos" class="form-label">Ordenar por</label>
                            <div class="input-group">
                                <select id="sortByPromos" class="form-select" name="sortBy" aria-describedby="sortPromosHelp">
                                    <option value="" disabled <?php echo $sortActual == '' ? 'selected' : ''; ?>>Ordenar por</option>
                                    <option value="promociones.codLocal" <?php echo $sortActual == 'codLocal' ? 'selected' : ''; ?>>Local</option>
                                    <option value="categoriaCliente" <?php echo $sortActual == 'categoriaCliente' ? 'selected' : ''; ?>>Tipo cliente</option>
                                    <option value="fechaDesdePromo" <?php echo $sortActual == 'fechaDesdePromo' ? 'selected' : ''; ?>>Fecha inicio</option>
                                    <option value="fechaHastaPromo" <?php echo $sortActual == 'fechaHastaPromo' ? 'selected' : ''; ?>>Fecha fin</option>
                                    <option value="codPromo" <?php echo $sortActual == 'codPromo' ? 'selected' : ''; ?>>ID promoción</option>
                                </select>
                                <button type="button" class="btn btn-outline-secondary order-toggle" onclick="toggleOrder(this.form)" aria-label="Cambiar orden a <?php echo $orderActual == 'ASC' ? 'descendente' : 'ascendente'; ?>" title="Cambiar orden: <?php echo $orderActual == 'ASC' ? 'Ascendente' : 'Descendente'; ?>">
                                    <i class="fas fa-sort-amount-<?php echo $orderActual == 'ASC' ? 'down' : 'up'; ?>" aria-hidden="true"></i>
                                </button>
                            </div>
                            <small id="sortPromosHelp" class="visually-hidden">Presione Aplicar para aplicar el orden seleccionado.</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" id="applySortPromos">Aplicar filtros</button>
                    </form>

                </section>
            </aside>
            <section class="col-lg-9 col-md-8">
                <?php
                    // Cerrar la conexión
                    mysqli_close($conexion);

                    $diaDesde = isset($_GET['diaDesde']) ? $_GET['diaDesde'] : '';
                    $diaHasta = isset($_GET['diaHasta']) ? $_GET['diaHasta'] : '';
                    $ordenar = isset($_GET['sortBy']) ? $_GET['sortBy'] : '';
                    $orden = isset($_GET['order']) ? $_GET['order'] : 'ASC';

                    if(!isset($_GET['page'])){
                        $pagina=1;
                    }else{
                        $pagina=(int) $_GET['page'];
                        if($pagina<=1){
                            $pagina=1;
                        }
                    };
                    $pagina=limpiar_cadena($pagina);

                    $url="index.php?vista=promocionesList&diaDesde=$diaDesde&diaHasta=$diaHasta&codLocal=$localActual&sortBy=$ordenar&order=$orden&page=";
                    $registros=3;

                    require_once (__DIR__. '/../php/listaPromociones.php');
                ?>
            </section>
        </div>
    </div>
</div>
<script>
function toggleOrder(form) {
    const orderInput = form.querySelector('input[name="order"]');
    const icon = form.querySelector('i[class*="fa-sort-amount-"]');
    const current = orderInput.value === 'ASC' ? 'ASC' : 'DESC';
    const newVal = current === 'ASC' ? 'DESC' : 'ASC';
    orderInput.value = newVal;
    if (icon) {
        icon.classList.remove('fa-sort-amount-down','fa-sort-amount-up');
        icon.classList.add('fa-sort-amount-' + (newVal === 'ASC' ? 'down' : 'up'));
    }
}
</script>




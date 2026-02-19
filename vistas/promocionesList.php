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
    <div class="container">
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

            $tipoUsuario = isset($_SESSION['tipoUsuario']) ? $_SESSION['tipoUsuario'] : '';
            $sortActual = isset ($_GET['sortBy']) ? $_GET['sortBy'] : '';
            $orderActual = isset($_GET['order']) ? $_GET['order'] : 'ASC';
        ?>
        <!-- Cambio de md de 10 a 4 para arrelgar muestro de promociones en pantallas chicas -->
        <div class="row calendarios">
            
            <!-- Formulario con un desplegable -->
            <div class="columnaFiltro1 col-lg-4 col-md-4 col-12">

                    <form action="index.php" method="get" id="sortForm">
                        <input type="hidden" name="vista" value="promocionesList">
                        <input type="hidden" name="order" value="<?php echo htmlspecialchars($orderActual); ?>">
                        <div class="calendarContainer">
                            <p>Selecciona una fecha</p>
                            <label for="diaDesde">Fecha Inicio:</label>
                            <input type="date" id="diaDesde" name="diaDesde" min="2000-01-01" max="9999-12-31">
                            <br>
                            <br>
                            <label for="diaHasta">Fecha Fin:</label>
                            <input type="date" id="diaHasta" name="diaHasta" min="2000-01-01" max="9999-12-31">
                            <br>
                            <button type="submit">Enviar</button>
                        </div>
                        <br>
                        <br>
                        <div class="">
                            <label for="sortByPromos" class="visually-hidden">Ordenar por</label>
                            <div class="input-group">
                                <select id="sortByPromos" class="form-select" name="sortBy" aria-label="Seleccionar orden" onchange="this.form.submit()">
                                    <option value="" disabled select <?php echo $sortActual == '' ? 'selected' : ''; ?>>Ordenar por</option>
                                    <option value="promociones.codLocal" <?php echo $sortActual == 'codLocal' ? 'selected' : ''; ?>>Local</option>
                                    <option value="categoriaCliente" <?php echo $sortActual == 'categoriaCliente' ? 'selected' : ''; ?>>Tipo cliente</option>
                                    <option value="fechaDesdePromo" <?php echo $sortActual == 'fechaDesdePromo' ? 'selected' : ''; ?>>Fecha inicio</option>
                                    <option value="fechaHastaPromo" <?php echo $sortActual == 'fechaHastaPromo' ? 'selected' : ''; ?>>Fecha fin</option>
                                    <option value="codPromo" <?php echo $sortActual == 'codPromo' ? 'selected' : ''; ?>>ID promoción</option>
                                </select>
                                <button type="button" class="btn btn-outline-secondary" onclick="toggleOrder(this.form)" title="Cambiar orden: <?php echo $orderActual == 'ASC' ? 'Ascendente' : 'Descendente'; ?>">
                                    <i class="fas fa-sort-amount-<?php echo $orderActual == 'ASC' ? 'down' : 'up'; ?>"></i>
                                </button>
                            </div>
                        </div>
                        <br>
                    </form>

                <?php 
                if($tipoUsuario == "Dueño"){
                    echo '<form action="index.php?vista=cargaPromociones" method="POST">
                            <div class="botonCrear">
                                <input type="submit" name="" class="btn btn-success crear" value="Crear Promoción">
                            </div>
                        </form>
                        ';     
                }
                ?>
            </div>
            <div class="columnaFiltro2 col-lg-7 col-md-7 col-12">
                <?php
                    // Cerrar la conexión
                    mysqli_close($conexion);

                    $diaDesde = isset($_GET['diaDesde']) ? $_GET['diaDesde'] : '';
                    $diaHasta = isset($_GET['diaHasta']) ? $_GET['diaHasta'] : '';
                    $localActual = isset($_GET['codLocal']) ? $_GET['codLocal'] : '';
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
            </div>
        </div>
    </div>
</div>
<script>
function toggleOrder(form) {
    const orderInput = form.querySelector('input[name="order"]');
    orderInput.value = orderInput.value === 'ASC' ? 'DESC' : 'ASC';
    form.submit();
}
</script>




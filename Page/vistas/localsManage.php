<div class="container-fluid p-0">
    <h1 class="title">Locales</h1>
</div>

<div class="row g-0">
    <?php
        require_once(__DIR__ . '/../php/main.php');
    ?>
    <div class="container">
        <br>
        <br>
        <br>
        <h1 class="text-center" style="color: white"><b>LOCALES</b></h1>
        <br>
        <div class="col md-6 lg-6">

            <?php
                // Establecer conexión
                $conexion = conexion();

                // Consulta para obtener los rubros
                $consulta_filtro = "SELECT * FROM rubros";
                $rubros = mysqli_query($conexion, $consulta_filtro);

                // Obtener el rubro actual de la URL (si está presente)
                $rubroActual = isset($_GET['rubroLocal']) ? $_GET['rubroLocal'] : '';
            ?>

<<<<<<< Updated upstream
            <div class="centered row mb-4">

                <div class="col-lg-3 col-md-3">
                <br>
                <br>
                    <form action="index.php?vista=cargaLocales" method="POST">
                        <div class="mb-3" style="display: flex; justify-content: right;">
                            <input type="submit" name="botonAnashe" class="btn btn-success sexo" value="Crear Local">
                        </div>    
                    </form>
                </div>

                <!-- Formulario con un desplegable -->
                <div class="col-lg-3 col-md-3">

                    <h2 class="text-center" style="color: white">Rubros</h2>
                    <form action="index.php" method="get" id="rubroForm">
                        <input type="hidden" name="vista" value="localsManage">
                        <div class="mb-3">
                            <select class="form-select" name="rubroLocal" aria-label="Seleccionar Rubro" onchange="this.form.submit()">
                                <option value="" <?php echo $rubroActual == '' ? 'selected' : ''; ?>>Todos</option>
                                <?php
                                // Crear las opciones del desplegable
                                foreach ($rubros as $row) {
                                    $nombreRubro = htmlspecialchars($row['nombreRubro']);
                                    $selected = $rubroActual == $nombreRubro ? 'selected' : '';
                                    echo '<option value="' . $nombreRubro . '" ' . $selected . '>' . $nombreRubro . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </form>

                </div>
=======
<div class="centered row mb-4 d-flex align-items-center justify-content-between">
    <!-- Botón Crear Local -->
    <div class="col-lg-3 col-md-3 d-flex align-items-center">
        <form action="index.php?vista=cargaLocales" method="POST">
            <input type="submit" name="botonAnashe" class="btn btn-success" value="Crear Local">
        </form>
    </div>
>>>>>>> Stashed changes

    <!-- Filtro de Rubros y Buscador en la misma línea -->
    <div class="col-lg-6 col-md-6 d-flex align-items-center">
        <!-- Filtro de Rubros -->
        <form action="index.php" method="get" id="rubroForm" class="d-flex align-items-center me-2">
            <input type="hidden" name="vista" value="localsList">
            <label for="rubroLocal" class="text-white me-2">Rubros:</label>
            <select class="form-select" name="rubroLocal" id="rubroLocal" onchange="this.form.submit()">
                <option value="" <?php echo $rubroActual == '' ? 'selected' : ''; ?>>Todos</option>
                <?php
                foreach ($rubros as $row) {
                    $nombreRubro = htmlspecialchars($row['nombreRubro']);
                    $selected = $rubroActual == $nombreRubro ? 'selected' : '';
                    echo '<option value="' . $nombreRubro . '" ' . $selected . '>' . $nombreRubro . '</option>';
                }
                ?>
            </select>
        </form>

        <!-- Buscador -->
        <form action="" method="POST" autocomplete="off" class="flex-grow-1">
            <input type="hidden" name="modulo_buscador" value="locales">
            <div class="input-group">
                <input 
                    type="text" 
                    name="txt_buscador" 
                    class="form-control rounded" 
                    placeholder="¿Qué local estás buscando?" 
                    pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}"
                    maxlength="30"
                    value="<?php echo isset($_SESSION['busquedaLocal']) ? htmlspecialchars($_SESSION['busquedaLocal']) : ''; ?>"
                >
                <button type="submit" class="btn btn-info">Buscar</button>
            </div>
        </form>
    </div>
</div>


        <div class="container">
            <?php
                $rubroLocal = (isset($_GET['rubroLocal'])) ? $_GET['rubroLocal'] : '';

                if(!isset($_GET['page'])){
                    $pagina=1;
                }else{
                    $pagina=(int) $_GET['page'];
                    if($pagina<=1){
                        $pagina=1;
                    }
                };

                $pagina=limpiar_cadena($pagina);
                $url="index.php?vista=localsManage&rubroLocal=$rubroLocal&page=";
                $registros = 1;
                $busqueda = (isset( $_SESSION['busquedaLocal'])) ? $_SESSION['busquedaLocal'] : '';

                # Paginador locales #
                require_once (__DIR__. '/../php/admin/gestionarLocales.php');

            ?>
        </div>
    </div>
</div>

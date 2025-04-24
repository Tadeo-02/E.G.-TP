<div class="container-fluid p-0">
    <h1 class="title">Locales</h1>
</div>

<div class="row g-0">
    <?php
        require_once(__DIR__ . '/../php/main.php');
    ?>
    <div class="container widht">
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
                $sortActual = isset ($_GET['sortBy']) ? $_GET['sortBy'] : '';
            ?>

            <div class="centered row mb-4">

                <?php if (isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario'] == "Administrador") { ?>
                    <div class="col-lg-3 col-md-3 col-12 mb-3">
                        <form action="index.php?vista=cargaLocales" method="POST">
                            <div class="botonCrear">
                                <input type="submit" name="" class="btn btn-success crear" value="Crear Local">
                            </div>
                        </form>
                    </div>
                <?php } ?>

                <!-- Formularios con desplegable -->
                <form action="index.php" method="get" id="rubroForm" class="col-lg-5 col-md-5">
                    <input type="hidden" name="vista" value="localsList">
                    <div class="row mb-3">
                        <div class="col">
                            <select class="form-select" name="sortBy" aria-label="Seleccionar orden" onchange="this.form.submit()">
                                <option value="" disabled select <?php echo $sortActual == '' ? 'selected' : ''; ?>>Ordenar por</option>
                                <option value="nombreLocal" <?php echo $sortActual == 'nombreLocal' ? 'selected' : ''; ?>>Nombre</option>
                                <option value="ubicacionLocal" <?php echo $sortActual == 'ubicacionLocal' ? 'selected' : ''; ?>>Ubicación</option>
                                <option value="codLocal" <?php echo $sortActual == 'codLocal' ? 'selected' : ''; ?>>Codigo de local</option>
                                <option value="rubroLocal" <?php echo $sortActual == 'rubroLocal' ? 'selected' : ''; ?>>Rubro</option>
                            </select>
                        </div>
                        <div class="col">    
                            <select class="form-select" name="rubroLocal" aria-label="Seleccionar Rubro" onchange="this.form.submit()">
                                <option value="" <?php echo $rubroActual == '' ? 'selected' : ''; ?>>Todos los rubros</option>
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
                    </div>
                </form>

                <?php
                    // Cerrar la conexión
                    mysqli_close($conexion);

                    if(isset($_POST['modulo_buscador'])) {
                        require_once (__DIR__ . '/../php/buscador.php');
                    }
                    
                ?>
                
                <div class="col-lg-3 col-md-3">
                    <form action="" method="POST" autocomplete="off">
                        <input type="hidden" name="modulo_buscador" value="locales">
                        <div class="input-group">
                            <input 
                                type="text" 
                                name="txt_buscador" 
                                class="form-control rounded-pill" 
                                placeholder="¿Qué local estas buscando?" 
                                pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}"
                                maxlength="30"
                                value="<?php echo isset($_SESSION['busquedaLocal']) ? htmlspecialchars($_SESSION['busquedaLocal']) : ''; ?>"
                                >
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="container">
            <?php
                $rubroLocal = (isset($_GET['rubroLocal'])) ? $_GET['rubroLocal'] : '';
                $ordenar = (isset($_GET['sortBy'])) ? $_GET['sortBy'] : 'nombreLocal';

                if(!isset($_GET['page'])){
                    $pagina=1;
                }else{
                    $pagina=(int) $_GET['page'];
                    if($pagina<=1){
                        $pagina=1;
                    }
                };

                $pagina=limpiar_cadena($pagina);
                $url="index.php?vista=localsList&rubroLocal=$rubroLocal&sortBy=$ordenar&page=";
                $registros = 1;
                $busqueda = (isset( $_SESSION['busquedaLocal'])) ? $_SESSION['busquedaLocal'] : '';

                require_once (__DIR__. '/../php/listaLocales.php');
            ?>
        </div>
    </div>
</div>




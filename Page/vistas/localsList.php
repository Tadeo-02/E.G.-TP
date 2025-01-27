<div class="container is-fluid mb-6">
    <h1 class="title">Productos</h1>
    <h2 class="subtitle">Lista de productos por categoría</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once(__DIR__ . '/../php/main.php');
    ?>
    <div class="columns">
        <div class="col-md-4">
            <h2 class="text-center">Rubros</h2>
            <?php
                // Establecer conexión
                $conexion = conexion();

                // Consulta para obtener los rubros
                $consulta_filtro = "SELECT * FROM rubros";
                $rubros = mysqli_query($conexion, $consulta_filtro);

                // Obtener el rubro actual de la URL (si está presente)
                $rubroActual = isset($_GET['rubroLocal']) ? $_GET['rubroLocal'] : '';
            ?>

            <!-- Formulario con un desplegable -->
            <form action="index.php" method="get" id="rubroForm">
                <input type="hidden" name="vista" value="localsList">
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

            <?php
                // Cerrar la conexión
                mysqli_close($conexion);
            ?>
        </div>

        <div class="column">
            <?php
                $rubroLocal = (isset($_GET['rubroLocal'])) ? $_GET['rubroLocal'] : "";

                /*== Verificando categoria ==*/
                $conexion=conexion();

                $consulta_rubro = "SELECT * FROM locales WHERE rubroLocal = '$rubroLocal'";

                $check_rubro = mysqli_query($conexion, $consulta_rubro);

                if(!isset($_GET['page'])){
                    $pagina=1;
                }else{
                    $pagina=(int) $_GET['page'];
                    if($pagina<=1){
                        $pagina=1;
                    }
                };

                $pagina=limpiar_cadena($pagina);
                $url="index.php?vista=localsList&rubroLocal=$rubroLocal&page="; /* <== */
                $registros=3;
                $busqueda="";

                # Paginador locales #
                require_once (__DIR__. '/../php/listaLocales.php');

                $check_rubro=null;
            ?>
        </div>
    </div>
</div>




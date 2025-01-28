<div class="container-fluid p-0">
    <h1 class="title">Productos</h1>
</div>

<div class="row g-0">
    <?php
        require_once(__DIR__ . '/../php/main.php');
    ?>
    <div class="container">
        <br>
        <h1 class="text-center" style="color: white"><b>Locales</b></h1>
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

            <div class="centered row mb-4">
                <!-- Formulario con un desplegable -->
                <div class="col-lg-3 col-md-3">
                    <!-- <h2 class="text-center">Rubros</h2> -->
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
                </div>
                <?php
                    // Cerrar la conexión
                    mysqli_close($conexion);

                    if(isset($_POST['modulo_buscador'])) {
                        require_once (__DIR__ . '/../php/buscador.php');
                    }
                
                    // if((!isset($_SESSION['busquedaLocal']) && empty($_SESSION['busquedaLocal'])) || $_SESSION['busquedaLocal'] == ''){
                    
                ?>
                

                <div class="col-lg-3 col-md-3">
                    <form action="" method="POST" autocomplete="off">
                        <input type="hidden" name="modulo_buscador" value="locales">
                        <div class="input-group">
                            <input 
                                type="text" 
                                name="txt_buscador" 
                                class="form-control rounded-pill" 
                                placeholder="¿Qué estas buscando?" 
                                pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}"
                                maxlength="30">
                            <button type="submit" class="btn btn-info rounded-pill">Buscar</button>
                        </div>
                    </form>
                </div>


            </div>
                    <!-- < ? php -->
                    
                    <!-- }else{ -->
                    
                    <!-- ? > -->
                        <!-- <div class="centered row">
                            <div class="col-12 text-center">
                                <form action="" method="POST" autocomplete="off">
                                    <input type="hidden" name="modulo_buscador" value="locales">
                                    <div class="input-group">
                                        <input 
                                            type="text" 
                                            name="txt_buscador" 
                                            class="form-control rounded-pill" 
                                            placeholder= "¿Qué estas buscando?" 
                                            pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}"
                                            maxlength="30">
                                        <button type="submit" class="btn btn-info rounded-pill">Buscar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
             -->
        </div>

        <div class="container">
            <?php
                // }
                $rubroLocal = (isset($_GET['rubroLocal'])) ? $_GET['rubroLocal'] : '';

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
                $busqueda= $_SESSION['busquedaLocal'];

                # Paginador locales #
                require_once (__DIR__. '/../php/listaLocales.php');

                $check_rubro=null;
            ?>
        </div>
    </div>
</div>




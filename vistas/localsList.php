<div class="container-fluid p-0">
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
                $orderActual = isset($_GET['order']) ? $_GET['order'] : 'ASC';
            ?>

            <fieldset>
            <legend class="visually-hidden">Filtros de locales</legend>
            <div class="centered row mb-4">

                <?php if (isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario'] == "Administrador") { ?>
                    <div class="col-lg-3 col-md-3 col-12 mb-3">
                        <form action="index.php?vista=cargaLocales" method="POST">
                            <div class="botonCrear">
                                <input type="submit" name="" class="btn btn-success crear" value="Crear Local">
                            </div>
                        </form>
                    </div>
                <?php } 
                
                    // Cerrar la conexión
                    mysqli_close($conexion);

                    // Procesar búsqueda: soportar tanto POST (formulario buscador) como
                    // GET cuando el usuario hace click en "Aplicar" y copiamos el texto
                    if (isset($_POST['modulo_buscador']) || isset($_GET['modulo_buscador'])) {
                        if (!isset($_POST['modulo_buscador']) && isset($_GET['modulo_buscador'])) {
                            $_POST['modulo_buscador'] = $_GET['modulo_buscador'];
                            if (isset($_GET['txt_buscador'])) {
                                $_POST['txt_buscador'] = $_GET['txt_buscador'];
                            }
                        }
                        require_once (__DIR__ . '/../php/buscador.php');
                    }
                    
                ?>
                
                <div class="col-lg-3 col-md-3">
                    <form action="" method="POST" autocomplete="off">
                        <input type="hidden" name="modulo_buscador" value="locales">
                        <div class="input-group">
                            <label for="txt_buscador" class="visually-hidden">Buscador de locales</label>
                            <input 
                                id="txt_buscador"
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

                <!-- Formularios con desplegable -->
                <form action="index.php" method="get" id="rubroForm" class="col-lg-5 col-md-5">
                    <input type="hidden" name="vista" value="localsList">
                    <input type="hidden" name="order" value="<?php echo htmlspecialchars($orderActual); ?>">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="sortByLocales" class="visually-hidden">Seleccionar orden listado</label>
                            <div class="input-group">
                                <select id="sortByLocales" class="form-select" name="sortBy">
                                    <option value="nombreLocal" <?php echo $sortActual == 'nombreLocal' ? 'selected' : ''; ?>>Nombre</option>
                                    <option value="ubicacionLocal" <?php echo $sortActual == 'ubicacionLocal' ? 'selected' : ''; ?>>Ubicación</option>
                                    <option value="codLocal" <?php echo $sortActual == 'codLocal' ? 'selected' : ''; ?>>Codigo de local</option>
                                    <option value="rubroLocal" <?php echo $sortActual == 'rubroLocal' ? 'selected' : ''; ?>>Rubro</option>
                                </select>
                                <button type="button" class="btn btn-outline-secondary" onclick="toggleOrder(this.form)" aria-label="Cambiar orden">
                                    <i id="orderIcon" class="fas fa-sort-amount-<?php echo $orderActual == 'ASC' ? 'down' : 'up'; ?>"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col d-flex align-items-center">    
                            <label for="rubroLocalFiltro" class="visually-hidden">Seleccionar rubro</label>
                            <select id="rubroLocalFiltro" class="form-select me-2 flex-grow-1" name="rubroLocal" aria-label="Seleccionar Rubro">
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
                            <button type="submit" class="btn btn-primary" id="applyFiltersBtn">Aplicar</button>
                        </div>
                    </div>
                </form>

            </div>
            </fieldset>
        </div>

        <div class="container">
            <div class="row g-4">
            <!-- Filtro para ordenar -->
            <?php
                $rubroLocal = (isset($_GET['rubroLocal'])) ? $_GET['rubroLocal'] : '';
                $ordenar = (isset($_GET['sortBy'])) ? $_GET['sortBy'] : 'nombreLocal';
                $orden = (isset($_GET['order'])) ? $_GET['order'] : 'ASC';

                if(!isset($_GET['page'])){
                    $pagina=1;
                }else{
                    $pagina=(int) $_GET['page'];
                    if($pagina<=1){
                        $pagina=1;
                    }
                };

                $pagina=limpiar_cadena($pagina);
                $url="index.php?vista=localsList&rubroLocal=$rubroLocal&sortBy=$ordenar&order=$orden&page=";
                $registros = 10;
                $busqueda = (isset( $_SESSION['busquedaLocal'])) ? $_SESSION['busquedaLocal'] : '';

                require_once (__DIR__. '/../php/listaLocales.php');
            ?>
            <script>
            function toggleOrder(form) {
                const orderInput = form.querySelector('input[name="order"]');
                const icon = document.getElementById('orderIcon');
                const current = orderInput.value === 'ASC' ? 'ASC' : 'DESC';
                const newVal = current === 'ASC' ? 'DESC' : 'ASC';
                orderInput.value = newVal;
                if (icon) {
                    icon.classList.remove('fa-sort-amount-down','fa-sort-amount-up');
                    icon.classList.add('fa-sort-amount-' + (newVal === 'ASC' ? 'down' : 'up'));
                }
            }
            </script>
            <script>
            // Copiar el valor del buscador al formulario de filtros cuando se hace submit (Aplicar)
            document.addEventListener('DOMContentLoaded', function() {
                const rubroForm = document.getElementById('rubroForm');
                const searchInput = document.getElementById('txt_buscador');
                if (rubroForm && searchInput) {
                    rubroForm.addEventListener('submit', function() {
                        let hiddenTxt = rubroForm.querySelector('input[name="txt_buscador"]');
                        if (!hiddenTxt) {
                            hiddenTxt = document.createElement('input');
                            hiddenTxt.type = 'hidden';
                            hiddenTxt.name = 'txt_buscador';
                            rubroForm.appendChild(hiddenTxt);
                        }
                        hiddenTxt.value = searchInput.value;

                        let modHidden = rubroForm.querySelector('input[name="modulo_buscador"]');
                        if (!modHidden) {
                            modHidden = document.createElement('input');
                            modHidden.type = 'hidden';
                            modHidden.name = 'modulo_buscador';
                            rubroForm.appendChild(modHidden);
                        }
                        modHidden.value = 'locales';
                    });
                }
            });
            </script>
            </div>
        </div>
    </div>
</div>




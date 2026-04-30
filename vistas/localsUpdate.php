<section id="about" class="about">
	<div class="container-fluid">
            <?php
                require_once(__DIR__ . '/../php/main.php');
                if (isset($_SESSION['mensaje'])) {
                    $tipoMsg = 'info';
                    $textoMsg = '';
                    if (is_array($_SESSION['mensaje'])) {
                        $tipoMsg = $_SESSION['mensaje']['tipo'] ?? 'info';
                        $textoMsg = $_SESSION['mensaje']['texto'] ?? '';
                    } else {
                        $textoMsg = $_SESSION['mensaje'];
                    }
                    echo '<div class="alert alert-' . htmlspecialchars($tipoMsg) . ' alert-dismissible fade show text-center" role="alert" style="margin-top: 20px;">
                            ' . htmlspecialchars($textoMsg) . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
                    unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
                }
            ?>
            <div class="row cargaPromociones">
                <div class="col-12">
                    <br>
                    <h1 class="text-center" style="color: white">MODIFICACIÓN DE LOCALES</h1>

                <div class="container">
                    <div class="form-container form-container-locales">
                        <h2 class="text-center mb-4 h3">Formulario de Modificacion del Local</h2>
                        <form action="php/admin/editarLocales.php" method="POST" id="solicitudPromocionForm">
                            <?php
                                // Establecer conexión
                                $conexion = conexion();

                                // Consulta para obtener los rubros
                                $consulta_rubros = "SELECT * FROM rubros";
                                $rubros = mysqli_query($conexion, $consulta_rubros);

                                // Obtener los datos del local
                                $codActual = isset($_POST['codLocal']) ? $_POST['codLocal'] : '';
                                $nombreActual = isset($_POST['nombreLocal']) ? $_POST['nombreLocal'] : '';
                            ?>

                            <!-- Local -->
                            <div class="mb-3">
                                <br>
                                <label for="localModificado" class="form-label" style="color: black; text-align: left; display:block;">Local a modificar:</label>
                                <select id="localModificado" class="form-select" name="localModificado" required>
                                    <?php
                                        $placeholderSelected = $codActual === '' ? ' selected' : '';
                                        echo '<option value="" disabled' . $placeholderSelected . '>Seleccione un local</option>';
                                        if ($codActual !== '') {
                                            echo '<option value="' . $codActual . '" selected>' . $nombreActual . '</option>';
                                        }
                                    ?>        
                                </select>
                            </div>
                            
                            <!-- Nuevo Nombre -->
                            <div class="mb-3">
                                <br>
                                <label for="nombreLocal" class="form-label">Nombre del local</label>
                                <input id="nombreLocal" class="form-control" type="text" name="nombreLocal" placeholder="Ingrese el nuevo nombre del local aquí..." maxlength="70" required>
                            </div>

                            <!-- Nuevo Rubro -->
                            <div class="mb-3">
                                <br>
                                <label for="rubroLocal" class="form-label" style="color: black; text-align: left; display:block;">Rubro de Local:</label>
                                <select id="rubroLocal" class="form-select" name="rubroLocal" required>
                                    <option value="" disabled selected>Seleccione un Rubro</option>
                                    <?php
                                    // Crear las opciones del desplegable
                                    foreach ($rubros as $row) {
                                        $nombreRubro = htmlspecialchars($row['nombreRubro']);
                                        echo '<option value="' . $nombreRubro . '">' . $nombreRubro . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Ubicación del Local -->
                            <div class="mb-3">
                                <br>
                                <label for="ubicacionLocal" class="form-label">Ubicación del Local:</label>
                                <select id="ubicacionLocal" class="form-select" name="ubicacionLocal" required>
                                    <option value="" disabled selected>Seleccione el piso: </option>
                                    <option value="Planta Baja">Planta Baja</option>
                                    <option value="Piso 1">Piso 1</option>
                                    <option value="Piso 2">Piso 2</option>
                                </select>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary botonPromo">Cargar</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
                
                <?php
                    // Cerrar la conexión
                    mysqli_close($conexion);
                ?>
                     
                </div>
            </div>
	</div>		

</section>
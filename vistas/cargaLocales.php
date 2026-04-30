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
                <h1 class="text-center" style="color: white">CARGA DE LOCALES</h1>
<!-- Form con para cargar Local -->

                <div class="container">
                    <div class="form-container form-container-locales">
                        <h2 class="text-center mb-4 h3">Formulario de Local</h2>
                        <form action="php/admin/altaLocales.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                            <?php
                                // Establecer conexión
                                $conexion = conexion();

                                // Consulta para obtener los rubros
                                $consulta_rubros = "SELECT * FROM rubros";
                                $consulta_usuarios = "SELECT * FROM usuarios WHERE tipoUsuario = 'Dueño'";

                                $rubros = mysqli_query($conexion, $consulta_rubros);
                                $dueños = mysqli_query($conexion, $consulta_usuarios);

                                
                            ?>

                            <!-- Nombre del Local -->
                            <div class="mb-3">
                                <label for="nombreLocal" class="form-label" style="color: black; text-align: left; display:block;">Nombre del local</label>
                                <input id="nombreLocal" class="form-control" type="text" name="nombreLocal" placeholder="Ingrese el nombre del local aquí..." maxlength="70" required>
                            </div>

                            <!-- Rubro del Local -->
                            <div class="mb-3">
                                <br>
                                <label for="rubroLocal" class="form-label" style="color: black; text-align: left; display:block;">Rubro de Local:</label>
                                <select id="rubroLocal" class="form-select" name="rubroLocal">
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

                            <!-- Ubicacion -->
                            <div class="mb-3">
                                <br>
                                <label for="ubicacionLocal" class="form-label">Ubicación del Local</label>
                                <select id="ubicacionLocal" class="form-select" name="ubicacionLocal" required>
                                    <option value="" disabled selected>Seleccione el piso: </option>
                                    <option value="Planta Baja">Planta Baja</option>
                                    <option value="Piso 1">Piso 1</option>
                                    <option value="Piso 2">Piso 2</option>
                                </select>
                            </div>

                            <!-- Dueño del Local -->
                            <div class="mb-3">
                                <br>
                                <label for="codUsuario" class="form-label" style="color: black; text-align: left; display:block;">Dueño del Local:</label>
                                <select id="codUsuario" class="form-select" name="codUsuario">
                                    <option value="" disabled selected>Seleccione el Dueño</option>
                                    <?php
                                    // Crear las opciones del desplegable
                                    foreach ($dueños as $row) {
                                        $codUsuario = htmlspecialchars($row['codUsuario']);
                                        $nombreUsuario = htmlspecialchars($row['nombreUsuario']);
                                        echo '<option value="' . $codUsuario . '">' . $codUsuario . ' - ' . $nombreUsuario . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Imagen del Local -->
                            <div class="mb-3">
                                <label for="imagenLocal" class="form-label" style="color: black; text-align: left; display:block;">Imagen del Local</label>
                                <input id="imagenLocal" class="form-control" type="file" name="imagenLocal" required>
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
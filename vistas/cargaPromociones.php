<section id="about" class="about">
	<div class="container-fluid">
            <div class="row cargaPromociones">
                <div class="col-12">
                    <br>
                    <h1 class="text-center" style="color: white">CARGA DE PROMOCIONES</h1>
                    

                <?php
                    require_once(__DIR__ . '/../php/main.php');
                    
                    // Iniciar sesión con el mismo nombre usado en la aplicación
                    if (session_status() !== PHP_SESSION_ACTIVE) {
                        session_name("UNR");
                        session_start();
                    }
                    
                    // Mostrar mensaje si existe
                    if (isset($_SESSION['mensaje'])) {
                        $tipoMsg = 'danger';
                        $textoMsg = '';
                        if (is_array($_SESSION['mensaje'])) {
                            $tipoMsg = $_SESSION['mensaje']['tipo'] ?? 'danger';
                            $textoMsg = $_SESSION['mensaje']['texto'] ?? '';
                        } else {
                            $textoMsg = $_SESSION['mensaje'];
                            if (strpos($textoMsg, 'éxito') !== false || strpos($textoMsg, 'registrada') !== false || strpos($textoMsg, 'correctamente') !== false) {
                                $tipoMsg = 'success';
                            }
                        }
                        echo '<div class="container" style="margin-top: 80px; position: relative; z-index: 9999;">'
                            . '<div class="alert alert-' . htmlspecialchars($tipoMsg) . ' alert-dismissible fade show" role="alert">'
                            . htmlspecialchars($textoMsg)
                            . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                            . '</div>'
                            . '</div>';
                        unset($_SESSION['mensaje']);
                    }
                ?>


                    <div class="container">
                        <div class="form-container form-container-locales">
                            
                            <!-- Form con para cargar promocion -->
                            <h2 class="text-center mb-4 h3">Solcitud de Promoción</h2>
                            <form action="php/duenoLocal/savePromociones.php" method="POST" id="solicitudPromocionForm">
                            <?php
                                // Establecer conexión
                                $conexion = conexion();

                                // Consulta para obtener los rubros
                                $codUsuarioActual = $_SESSION['codUsuario'];
                                $consulta_filtro = "SELECT * FROM locales WHERE codUsuario = $codUsuarioActual";

                                $locales = mysqli_query($conexion, $consulta_filtro);
                            ?>

                                <!-- Local -->
                                <div class="mb-3">
                                    <br>
                                    <label for="codLocal" class="form-label" style="color: black; text-align: left; display:block;">Local de la promoción:</label>
                                    <select id="codLocal" class="form-select" name="codLocal" required>
                                        <option value="" disabled selected>Seleccione un local</option>
                                        <?php
                                        // Crear las opciones del desplegable
                                        foreach ($locales as $row) {
                                            $nombreLocal = htmlspecialchars($row['nombreLocal']);
                                            $codLocal = htmlspecialchars($row['codLocal']);
                                            echo '<option value="' . $codLocal . '">' . $nombreLocal . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Descripción -->
                                <div class="mb-3">
                                    <br>
                                    <label for="textoPromo" class="form-label" style="color: black; text-align: left; display:block;">Descripción de la promoción:</label>
                                    <textarea id="textoPromo" class="form-control" name="textoPromo" rows="4" placeholder="Ingrese la descripción de la promoción aquí..." maxlength="500" required></textarea>
                                </div>

                                <!-- Fechas -->
                                <div class="mb-3">
                                    <br>
                                    <label for="fechaDesdePromo" class="form-label" style="color: black; text-align: left; display:block;">Fecha de inicio de la promoción:</label>
                                    <input id="fechaDesdePromo" class="form-control" type="date" name="fechaDesdePromo" min="<?php echo date('Y-m-d'); ?>" max="2099-12-31" required>
                                </div>

                                <div class="mb-3">
                                    <br>
                                    <label for="fechaHastaPromo" class="form-label" style="color: black; text-align: left; display:block;">Fecha de fin de la promoción:</label>
                                    <input id="fechaHastaPromo" class="form-control" type="date" name="fechaHastaPromo" min="<?php echo date('Y-m-d'); ?>" max="2099-12-31" required>
                                </div>

                                <!-- Categoría del cliente -->
                                <div class="mb-3">
                                    <br>
                                    <label for="categoriaCliente" class="form-label" style="color: black; text-align: left; display:block;">Categoría del cliente válida para la promoción:</label>

                                    <select id="categoriaCliente" class="form-select" name="categoriaCliente" required>
                                        <option value="" disabled selected>Seleccione una categoría</option>
                                        <option value="Inicial">Inicial</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Premium">Premium</option>
                                    </select>
                                </div>

                                <!-- Días de la promoción -->
                                <div class="mb-3" style="text-align: left;">
                                    <br>
                                    <label class="form-label" style="color: black; display:block;">Días en los que la promoción será válida:</label>

                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="diasSemana[]" id="dia1" value="1">
                                            <label class="form-check-label" for="dia1" style="color: black;">Lunes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="diasSemana[]" id="dia2" value="2">
                                            <label class="form-check-label" for="dia2" style="color: black;">Martes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="diasSemana[]" id="dia3" value="3">
                                            <label class="form-check-label" for="dia3" style="color: black;">Miércoles</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="diasSemana[]" id="dia4" value="4">
                                            <label class="form-check-label" for="dia4" style="color: black;">Jueves</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="diasSemana[]" id="dia5" value="5">
                                            <label class="form-check-label" for="dia5" style="color: black;">Viernes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="diasSemana[]" id="dia6" value="6">
                                            <label class="form-check-label" for="dia6" style="color: black;">Sábado</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="diasSemana[]" id="dia7" value="7">
                                            <label class="form-check-label" for="dia7" style="color: black;">Domingo</label>
                                        </div>
                                    </div>
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

<!-- Validación del formulario -->
<script>
    document.getElementById('solicitudPromocionForm').addEventListener('submit', function(e) {
        const fechaDesde = document.getElementById('fechaDesdePromo').value;
        const fechaHasta = document.getElementById('fechaHastaPromo').value;
        const hoy = new Date().toISOString().split('T')[0];
        let errores = [];

        if (fechaDesde < hoy) {
            errores.push('La fecha de inicio no puede ser anterior a hoy.');
        }
        if (fechaHasta <= fechaDesde) {
            errores.push('La fecha de fin debe ser posterior a la fecha de inicio.');
        }

        var checkboxes = document.querySelectorAll('input[name="diasSemana[]"]:checked');
        if (checkboxes.length === 0) {
            errores.push('Seleccione al menos un día para la promoción.');
        }

        if (errores.length > 0) {
            e.preventDefault();
            alert(errores.join('\n'));
        }
    });
</script>

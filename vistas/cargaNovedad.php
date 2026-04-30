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
                <h1 class="text-center" style="color: white">CARGA DE NOVEDADES</h1>
<!-- Form con para cargar novedad -->
                <div class="container">
                    <div class="form-container form-container-locales">
                        <h2 class="text-center mb-4 h3">Formulario de Novedad</h2>
                        <form action="php/admin/altaNovedades.php" method="POST" autocomplete="off" >
            
                            <!-- Texto Novedad -->
                            <div class="mb-3">
                                <label for="textoNovedad" class="form-label" style="color: black; text-align: left; display:block;">Texto:</label>
                                <textarea id="textoNovedad" class="form-control" name="textoNovedad" rows="4" placeholder="Ingrese el texto de la novedad aquí..." maxlength="500" required></textarea>
                            </div>

                            <!-- Fechas Novedad -->
                            <div class="mb-3">
                                    <br>
                                    <label for="fechaDesdeNovedad" class="form-label" style="color: black; text-align: left; display:block;">Fecha de inicio:</label>
                                    <input id="fechaDesdeNovedad" class="form-control" type="date" name="fechaDesdeNovedad" min="2000-01-01" max="2099-12-31" required>
                                </div>

                                <div class="mb-3">
                                    <br>
                                    <label for="fechaHastaNovedad" class="form-label" style="color: black; text-align: left; display:block;">Fecha de fin:</label>
                                    <input id="fechaHastaNovedad" class="form-control" type="date" name="fechaHastaNovedad" min="2000-01-01" max="2099-12-31" required>
                            </div>

                            <!-- Tipo de cliente -->
                            <div class="mb-3">
                                <br>
                                <label for="tipoCliente" class="form-label">Tipo de Cliente</label>
                                <select id="tipoCliente" class="form-select" name="tipoCliente" required>
                                    <option value="" disabled selected>Seleccione un nivel de Cliente</option>
                                    <option value="Inicial">Inicial</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Premium">Premium</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary botonPromo">Cargar</button>
                            </div>

                        </form>
                    </div>
                </div>                  
            </div>
        </div>
	</div>		

</section>
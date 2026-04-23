<section id="about" class="about">
	<div class="container-fluid">
            <?php
                require_once(__DIR__ . '/../php/main.php');
            ?>
            <div class="row cargaPromociones">
                <div class="col-12">  
                    <br>                 
                    <h1 class="text-center" style="color: white">CARGA DE NOVEDADES</h1>
                    

                <div class="container">
                        <div class="form-container form-container-locales">
                            <h2 class="text-center mb-4 h3">Formulario de Novedad</h2>
                        <form action="php/admin/editarNovedades.php" method="POST" autocomplete="off" >

                            <!-- Cod Novedad -->
                            <div class="mb-3">
                                <br>
                                <label for="novedadModificada" class="form-label" style="color: black; text-align: left; display:block;">Novedad a modificar:</label>
                                <select id="novedadModificada" class="form-select" name="novedadModificada" required>
                                    <?php
                                        $codActual = isset($_POST['codNovedad']) ? $_POST['codNovedad'] : '';
                                            $placeholderSelected = $codActual === '' ? ' selected' : '';
                                            echo '<option value="" disabled' . $placeholderSelected . '>Seleccione una novedad</option>';
                                            if ($codActual !== '') {
                                                echo '<option value="' . $codActual . '" selected>' . $codActual . '</option>';
                                            }
                                    ?>
                                </select>
                            </div>

                            <!-- Texto Novedad -->
                            <div class="mb-3">
                                <label for="textoNovedadUpdate" class="form-label" style="color: black; text-align: left; display:block;">Texto novedad</label>
                                <textarea id="textoNovedadUpdate" class="form-control" name="textoNovedad" rows="4" placeholder="Ingrese el texto de la novedad aquí..." maxlength="500" required></textarea>
                            </div>

                            <!-- Fechas Novedad -->
                            <div class="mb-3">
                                    <br>
                                    <label for="fechaDesdeNovedadUpdate" class="form-label" style="color: black; text-align: left; display:block;">Fecha de inicio de la Novedad:</label>
                                    <input id="fechaDesdeNovedadUpdate" class="form-control" type="date" name="fechaDesdeNovedad" min="2000-01-01" max="2099-12-31" required>
                                </div>

                                <div class="mb-3">
                                    <br>
                                    <label for="fechaHastaNovedadUpdate" class="form-label" style="color: black; text-align: left; display:block;">Fecha de fin de la Novedad:</label>
                                    <input id="fechaHastaNovedadUpdate" class="form-control" type="date" name="fechaHastaNovedad" min="2000-01-01" max="2099-12-31" required>
                            </div>

                            <!-- Tipo de cliente -->
                            <div class="mb-3">
                                <br>
                                <label for="tipoClienteUpdate" class="form-label">Tipo de Cliente</label>
                                <select id="tipoClienteUpdate" class="form-select" name="tipoCliente" required>
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
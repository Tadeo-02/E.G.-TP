<section id="about" class="about">
	<div class="container-fluid">
    
       <div class="form-rest"></div> <!--se utiliza para mostrar el resultado dentro de este "form-rest"  -->
            <?php
                require_once(__DIR__ . '/../php/main.php');
            ?>
            <div class="row cargaPromociones">
                <div class="col-12">                    
                    <h1>CARGA DE NOVEDADES</h1>
                    <br>
<head>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        select[multiple] {
            height: auto;
        }
    </style>
</head>

                <div class="container">
                    <div class="form-container">
                        <h3 class="text-center mb-4">Formulario de Novedad</h3>
                        <form action="php/admin/editarNovedades.php" method="POST" autocomplete="off" >

                            <!-- Cod Novedad -->
                            <div class="mb-3">
                                <br>
                                <label class="form-label" style="color: black; text-align: left; display:block;">Novedad a modificar:</label>
                                <select class="form-select" name="novedadModificada" required>
                                    <?php
                                        $codActual = isset($_POST['codNovedad']) ? $_POST['codNovedad'] : '';
                                        echo '<option value="'. $codActual .'">'.$codActual.'</option>';
                                    ?>
                                </select>
                            </div>

                            <!-- Texto Novedad -->
                            <div class="mb-3">
                                <label class="form-label" style="color: black; text-align: left; display:block;">Texto novedad</label>
                                <textarea class="form-control" name="textoNovedad" rows="4" placeholder="Ingrese el texto de la novedad aquí..." maxlength="500" required></textarea>
                            </div>

                            <!-- Fechas Novedad -->
                            <div class="mb-3">
                                    <br>
                                    <label class="form-label" style="color: black; text-align: left; display:block;">Fecha de inicio de la Novedad:</label>
                                    <input class="form-control" type="date" name="fechaDesdeNovedad" required>
                                </div>

                                <div class="mb-3">
                                    <br>
                                    <label class="form-label" style="color: black; text-align: left; display:block;">Fecha de fin de la Novedad:</label>
                                    <input class="form-control" type="date" name="fechaHastaNovedad" required>
                            </div>

                            <!-- Tipo de cliente -->
                            <div class="mb-3">
                                <br>
                                <label class="form-label">Tipo de Cliente</label>
                                <select class="form-select" name="tipoCliente" required>
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
<section id="about" class="about">
	<div class="container-fluid">
    
	    <div class="form-rest"></div> <!--se utiliza para mostrar el resultado dentro de este "form-rest"  -->
            <?php
                require_once(__DIR__ . '/../php/main.php');
            ?>
            <div class="row cargaPromociones">
                <div class="col-12">
                    <h1>CARGA DE LOCALES</h1>
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
                        <h3 class="text-center mb-4">Formulario de Modificacion del Local</h3>
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
                                <label class="form-label" style="color: black; text-align: left; display:block;">Local a modificar:</label>
                                <select class="form-select" name="localModificado" required>
                                    <?php
                                        echo '<option value="'. $codActual .'">'.$nombreActual.'</option>';
                                    ?>        
                                </select>
                            </div>
                            
                            <!-- Nuevo Nombre -->
                            <div class="mb-3">
                                <br>
                                <label class="form-label">Nombre del local</label>
                                <input class="form-control" type="text" name="nombreLocal" placeholder="Ingrese el nuevo nombre del local aquí..." maxlength="70" required>
                            </div>

                            <!-- Nuevo Rubro -->
                            <div class="mb-3">
                                <br>
                                <label class="form-label" style="color: black; text-align: left; display:block;">Rubro de Local:</label>
                                <select class="form-select" name="rubroLocal" required>
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
                                <label class="form-label">Ubicación del Local:</label>
                                <select class="form-select" name="ubicacionLocal" required>
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
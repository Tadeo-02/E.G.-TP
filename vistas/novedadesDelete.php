
<section id="about" class="about">
	<div class="container-fluid">
    
        <div class="form-rest"></div>
            <?php
                require_once(__DIR__ . '/../php/main.php');
            ?>
            <div class="row cargaPromociones">
                <div class="col-12">
                    <h1>ELIIMINAR LOCALES</h1>
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
                        <h3 class="text-center mb-4">Formulario de Eliminación de Novedades</h3>
                        <form action="/TP ENTORNOS/php/admin/eliminarLocales.php" method="POST">
                        <?php
                                // Establecer conexión
                                $conexion = conexion();

                                $consulta_locales = "SELECT * FROM locales";

                                $locales = mysqli_query($conexion, $consulta_locales);
                            ?>

                            <!-- Local -->
                            <div class="mb-3">
                                <br>
                                <label class="form-label" style="color: black; text-align: left; display:block;">Local a modificar:</label>
                                <select class="form-select" name="codLocal" required>
                                    <option value="" disabled selected>Seleccione una novedad</option>
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
            

                            <div class="text-center">
                            <button type="submit" class="btn btn-danger btn-lg">ELIMINAR NOVEDAD</button>
                            </div>

                            <?php

                            ?>

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
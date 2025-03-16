<section id="about" class="about">
	<div class="container-fluid">
    
	<!-- SE MUESTRA EL RESULTADO DEL FORM CON ESTE DIV "form-rest" -->
        <div class="form-rest"></div>
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
                        <h3 class="text-center mb-4">Formulario de Local</h3>
                        <form action="/TP ENTORNOS/php/admin/altaLocales.php" method="POST" autocomplete="off" enctype="multipart/form-data">
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
                                <label class="form-label" style="color: black; text-align: left; display:block;">Nombre del local</label>
                                <input class="form-control" type="text" name="nombreLocal" placeholder="Ingrese el nombre del local aquí..." maxlength="70" required>
                            </div>

                            <!-- Rubro del Local -->
                            <div class="mb-3">
                                <br>
                                <label class="form-label" style="color: black; text-align: left; display:block;">Rubro de Local:</label>
                                <select class="form-select" name="rubroLocal">
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

                            <!-- Días de la promoción -->
                            <div class="mb-3">
                                <br>
                                <label class="form-label">Ubicación del Local</label>
                                <select class="form-select" name="ubicacionLocal" required>
                                    <option value="" disabled selected>Seleccione una ubicacion</option>
                                    <option value="1 . 1">1 . 1</option>
                                    <option value="1 . 2">1 . 2</option>
                                    <option value="1 . 3">1 . 3</option>
                                    <option value="1 . 4">1 . 4</option>
                                    <option value="2 . 1">2 . 1</option>
                                    <option value="2 . 2">2 . 2</option>
                                    <option value="2 . 3">2 . 3</option>
                                    <option value="2 . 4">2 . 4</option>
                                    <option value="2 . 5">2 . 5</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <br>
                                <label class="form-label" style="color: black; text-align: left; display:block;">Dueño del Local:</label>
                                <select class="form-select" name="codUsuario">
                                    <option value="" disabled selected>Seleccione el Dueño</option>
                                    <?php
                                    // Crear las opciones del desplegable
                                    foreach ($dueños as $row) {
                                        $codUsuario = htmlspecialchars($row['codUsuario']);
                                        echo '<option value="' . $codUsuario . '">' . $codUsuario . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <br>

                            <div class="mb-3">
                                <label class="form-label" style="color: black; text-align: left; display:block;">Imagen del Local</label>
                                <input class="form-control" type="file" name="imagenLocal" required>
                            </div>

                            <br>

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
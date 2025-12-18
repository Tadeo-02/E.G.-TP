<section id="about" class="about">
	<div class="container-fluid">
        
        <div class="form-rest"></div> <!--se utiliza para mostrar el resultado dentro de este "form-rest"  -->
        <?php
            require_once(__DIR__ . '/../php/main.php');
            
            // Mostrar mensaje de éxito si existe
            if (isset($_SESSION['mensaje'])) {
                echo '<div class="alert alert-' . $_SESSION['mensaje']['tipo'] . ' alert-dismissible fade show" role="alert">
                        ' . htmlspecialchars($_SESSION['mensaje']['texto']) . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
            }
        ?>
            <div class="row cargaPromociones">
                <div class="col-12">
                    <h1>CARGA DE PROMOCIONES</h1>
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
<!-- Form con para cargar promocion -->

                    <div class="container">
                        <div class="form-container">
                            <h3 class="text-center mb-4">Solcitud de Promoción</h3>
                            <form action="php/dueñoLocal/savePromociones.php" method="POST" id="solicitudPromocionForm">
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
                                    <label class="form-label" style="color: black; text-align: left; display:block;">Local de la promoción:</label>
                                    <select class="form-select" name="codLocal" required>
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
                                    <label class="form-label" style="color: black; text-align: left; display:block;">Descripción de la promoción:</label>
                                    <textarea class="form-control" name="textoPromo" rows="4" placeholder="Ingrese la descripción de la promoción aquí..." maxlength="500" required></textarea>
                                </div>

                                <!-- Fechas -->
                                <div class="mb-3">
                                    <br>
                                    <label class="form-label" style="color: black; text-align: left; display:block;">Fecha de inicio de la promoción:</label>
                                    <input class="form-control" type="date" name="fechaDesdePromo" required>
                                </div>

                                <div class="mb-3">
                                    <br>
                                    <label class="form-label" style="color: black; text-align: left; display:block;">Fecha de fin de la promoción:</label>
                                    <input class="form-control" type="date" name="fechaHastaPromo" required>
                                </div>

                                <!-- Categoría del cliente -->
                                <div class="mb-3">
                                    <br>
                                    <label class="form-label" style="color: black; text-align: left; display:block;">Categoría del cliente válida para la promoción:</label>

                                    <select class="form-select" name="categoriaCliente" required>
                                        <option value="" disabled selected>Seleccione una categoría</option>
                                        <option value="Inicial">Inicial</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Premium">Premium</option>
                                    </select>
                                </div>

                                <!-- Días de la promoción -->
                                <div class="mb-3">
                                    <br>
                                    <label class="form-label" style="color: black; text-align: left; display:block;">Días en los que la promoción será válida: </label>

                                    <select class="form-select" multiple size="7" name="diasSemana[]" id="diasSemana" required>
                                        <option value="1">Lunes</option>
                                        <option value="2">Martes</option>
                                        <option value="3">Miércoles</option>
                                        <option value="4">Jueves</option>
                                        <option value="5">Viernes</option>
                                        <option value="6">Sábado</option>
                                        <option value="7">Domingo</option>
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
<!-- Selector de los días con JS -->
<script>
    new MultiSelectTag('diasSemana', {
    rounded: true,    
    shadow: true,      
    placeholder: 'Search',  
    tagColor: {
        textColor: '#000000',
        borderColor: '#ffca2c',
        bgColor: '#ffca2c',
    },
    onChange: function(values) {
        console.log(values)
    }
})
</script>

<script>
    function mostrarSeleccion() {
        let select = document.getElementById("miSelect");
        let seleccionadas = Array.from(select.selectedOptions).map(opt => opt.value);
        alert("Opciones seleccionadas: " + seleccionadas.join(", "));
    }
</script>
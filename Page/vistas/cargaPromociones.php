
<section id="about" class="about">
	<div class="container-fluid">
    
	<!-- SE MUESTRA EL RESULTADO DEL FORM CON ESTE DIV "form-rest" -->
        <div class="form-rest"></div>

            <div class="row cargaPromociones">
                <div class="col-12">
                    <form action="/TP ENTORNOS/Page/php/savePromociones.php" method="POST" class="form" autocomplete="off" >
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

                <div class="container">
                    <div class="form-container">
                        <h3 class="text-center mb-4">Formulario de Promoción</h3>
                        <form>
                            <!-- Descripción -->
                            <div class="mb-3">
                                <label class="form-label">Descripción de la promoción</label>
                                <input class="form-control" type="text" name="textoPromo" placeholder="Ingrese la descripción de la promoción aquí..." maxlength="70" required>
                            </div>

                            <!-- Fechas -->
                            <div class="mb-3">
                                <label class="form-label">Fecha de inicio de la promoción</label>
                                <input class="form-control" type="date" name="fechaDesdePromo" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Fecha de fin de la promoción</label>
                                <input class="form-control" type="date" name="fechaHastaPromo" required>
                            </div>

                            <!-- Categoría del cliente -->
                            <div class="mb-3">
                                <label class="form-label">Categoría del cliente válida para la promoción</label>
                                <select class="form-select" name="categoriaCliente" required>
                                    <option value="" disabled selected>Seleccione una categoría</option>
                                    <option value="1">Inicial</option>
                                    <option value="2">Medium</option>
                                    <option value="3">Premium</option>
                                </select>
                            </div>

                            <!-- Días de la promoción -->
                            <div class="mb-3">
                                
                            <label class="form-label" style="color: black; text-align: left; display:block;">Días en los que la promoción será válida: </label>

                                <select class="form-select" multiple size="7" name="diasSemana" id="diasSemana" required>
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

                     
                </div>
            </div>
	</div>		

</section>
<script>
    new MultiSelectTag('diasSemana', {
    rounded: true,    // default true
    shadow: true,      // default false
    placeholder: 'Search',  // default Search...
    tagColor: {
        textColor: '#327b2c',
        borderColor: '#92e681',
        bgColor: '#eaffe6',
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
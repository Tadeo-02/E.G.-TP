<section id="about" class="about">
	<div class="container-fluid">
    
	<!-- SE MUESTRA EL RESULTADO DEL FORM CON ESTE DIV "form-rest" -->
        <div class="form-rest"></div>

            <div class="row cargaPromociones">
                <div class="col-12">
                    <form action="/TP ENTORNOS/Page/php/admin/altaLocales.php" method="POST" class="form" autocomplete="off" >
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
                        <form>
                            <!-- Descripción -->
                            <div class="mb-3">
                                <label class="form-label">Nombre del local</label>
                                <input class="form-control" type="text" name="nombreLocal" placeholder="Ingrese el nombre del local aquí..." maxlength="70" required>
                            </div>

                            <!-- Categoría del cliente -->
                            <div class="mb-3">
                                <label class="form-label">Rubro de Local</label>
                                <select class="form-select" name="rubroLocal" required>
                                    <option value="" disabled selected>Seleccione un rubro para su local</option>
                                    <option value="Electrónica">Electrónica</option>
                                    <option value="Perfumería">Perfumería</option>
                                    <option value="Gastronomía">Gastronomía</option>
                                    <option value="Indumentaria">Indumentaria</option>
                                    <option value="Librería">Librería</option>
                                    <option value="Juguetería">Juguetería</option>
                                    <option value="Bazar">Bazar</option>
                                    <option value="Deportes">Deportes</option>
                                    <option value="Calzado">Calzado</option>
                                </select>
                            </div>

                            <!-- Días de la promoción -->
                            <div class="mb-3">
                                <label class="form-label">Ubicación del Local</label> //? REVISAR
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
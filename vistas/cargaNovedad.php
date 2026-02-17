<section id="about" class="about">
	<div class="container-fluid">
    
        <div class="form-rest"></div>
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
<!-- Form con para cargar novedad -->
                <div class="container">
                    <div class="form-container">
                        <h3 class="text-center mb-4">Formulario de Novedad</h3>
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
                                    <input id="fechaDesdeNovedad" class="form-control" type="date" name="fechaDesdeNovedad" min="2000-01-01" max="9999-12-31" required>
                                </div>

                                <div class="mb-3">
                                    <br>
                                    <label for="fechaHastaNovedad" class="form-label" style="color: black; text-align: left; display:block;">Fecha de fin:</label>
                                    <input id="fechaHastaNovedad" class="form-control" type="date" name="fechaHastaNovedad" min="2000-01-01" max="9999-12-31" required>
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
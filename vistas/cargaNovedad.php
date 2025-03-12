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

                <div class="container">
                    <div class="form-container">
                        <h3 class="text-center mb-4">Formulario de Novedad</h3>
                        <form action="/TP ENTORNOS/php/admin/altaNovedades.php" method="POST" autocomplete="off" >
            
                            <!-- Texto Novedad -->
                            <div class="mb-3">
                                <label class="form-label" style="color: black; text-align: left; display:block;">Texto:</label>
                                <input class="form-control" type="text" name="textoNovedad" placeholder="Ingrese el texto de la novedad aquí..." maxlength="100" required>
                            </div>

                            <!-- Fechas Novedad -->
                            <div class="mb-3">
                                    <br>
                                    <label class="form-label" style="color: black; text-align: left; display:block;">Fecha de inicio:</label>
                                    <input class="form-control" type="date" name="fechaDesdeNovedad" required>
                                </div>

                                <div class="mb-3">
                                    <br>
                                    <label class="form-label" style="color: black; text-align: left; display:block;">Fecha de fin:</label>
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
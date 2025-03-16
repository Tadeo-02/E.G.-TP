<div class="container-fluid p-0">
    <h1 class="title">Promociones</h1>
</div>

<div class="row g-0">
    <?php
        require_once(__DIR__ . '/../php/main.php');
    ?>
    <div class="container">
        <br>
        <br>
        <br>
        <h1 class="text-center" style="color: white"><b>PROMOCIONES</b></h1>
        <br>
        <?php
            // Establecer conexión
            $conexion = conexion();

            // Consulta para obtener las promociones
            $consulta_filtro = "SELECT * FROM promociones";
            $promociones = mysqli_query($conexion, $consulta_filtro);

            // Obtener el dia actual de la URL (si está presente)
            $diaDesdeActual = isset($_POST['diaDesde']) ? $_POST['diaDesde'] : '';
            $diaHastaActual = isset($_POST['diaHasta']) ? $_POST['diaHasta'] : '';

            $tipoUsuario = isset($_SESSION['tipoUsuario']) ? $_SESSION['tipoUsuario'] : '';
        ?>

        <div class="row calendarios col-lg-10 col-md-10 col-12">
            
            <!-- Formulario con un desplegable -->
            <div class="columnaFiltro col-lg-3 col-md-10 col-12">
                <div class="calendarContainer">
                    <p>Selecciona una fecha</p>
                    <form action="" method="POST">
                        <label for="diaDesde">Fecha Inicio:</label>
                        <input type="date" id="diaDesde" name="diaDesde">
                        <br>
                        <br>
                        <label for="diaHasta">Fecha Fin:</label>
                        <input type="date" id="diaHasta" name="diaHasta">
                        <br>

                        <button type="submit">Enviar</button>
                    </form>
                </div>

                <?php 
                if($tipoUsuario == "Dueño"){
                    echo '<div class="textContainer">
                            <br>
                            <form action="index.php?vista=cargaPromociones" method="POST">
                            <div class="mb-3" style="display: flex; justify-content: right;">
                                <input type="submit" name="botonAnashe" class="btn btn-success sexo" value="Crear Promoción">
                            </div>    
                            </form>
                        </div>';     
                }
                ?>
            </div>
            <div class="columnaPromo col-lg-7 col-md-10 col-12">
                <?php
                    // Cerrar la conexión
                    mysqli_close($conexion);

                    $diaDesde = isset($_POST['diaDesde']) ? $_POST['diaDesde'] : '';
                    $diaHasta = isset($_POST['diaHasta']) ? $_POST['diaHasta'] : '';
                    $localActual = isset($_GET['codLocal']) ? $_GET['codLocal'] : '';

                    if(!isset($_GET['page'])){
                        $pagina=1;
                    }else{
                        $pagina=(int) $_GET['page'];
                        if($pagina<=1){
                            $pagina=1;
                        }
                    };

                    $pagina=limpiar_cadena($pagina);
                    $url="index.php?vista=promocionesList&diaDesde=$diaDesde&diaHasta=$diaHasta&codLocal=$localActual&page="; 
                    $registros=3;

                    require_once (__DIR__. '/../php/listaPromociones.php');
                ?>
            </div>
        </div>
    </div>
</div>




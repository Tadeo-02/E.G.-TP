<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locales</title>
</head>

<body>

    <!-- <button class="e-filter-item" data-filter="Indumentaria" aria-pressed="false">Indumentaria</button>
    <button class="e-filter-item" data-filter="comida" aria-pressed="false">Comida</button>
    <button class="e-filter-item" data-filter="pefumeria" aria-pressed="false">Pefumer&iacute;a</button>
    <button class="e-filter-item" data-filter="optica" aria-pressed="false">&Oacute;ptica</button> -->

    <?php 
        $link = mysqli_connect("localhost", "root") or die("Problemas de conexión a la base de datos");
        mysqli_select_db($link, "tp entornos");
        
        $Cant_por_Pag = 2;
        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : null;
        if (!$pagina) {
            $inicio = 0;
            $pagina = 1;
        } else {
            $inicio = ($pagina - 1) * $Cant_por_Pag;
        } // total de páginas
        $vSql = "SELECT * FROM locales";
        $vResultado = mysqli_query($link, $vSql);
        $total_registros = mysqli_num_rows($vResultado);
        $total_paginas = ceil($total_registros / $Cant_por_Pag);
        echo "Numero de registros encontrados: " . $total_registros . "<br>";
        echo "Se muestran paginas de " . $Cant_por_Pag . " registros cada una<br>";
        echo "Mostrando la pagina " . $pagina . " de " . $total_paginas . "<p>";
        $vSql = "SELECT * FROM locales" . " limit " . $inicio . "," . $Cant_por_Pag;
        $vResultado = mysqli_query($link, $vSql);
        $total_registros = mysqli_num_rows($vResultado);
    ?>
    
    <table border=1>
        <tr>
            <td><b>Nombre</b></td>
            <td><b>Ubicaión</b></td>
            <td><b>Rubro</b></td>
        </tr>
        <?php
        while ($fila = mysqli_fetch_array($vResultado)) {
        ?>
            <tr>
                <td><?php echo ($fila['codLocal']); ?></td>
                <td><?php echo ($fila['nombreLocal']); ?></td>
                <td><?php echo ($fila['ubicaionLocal']); ?></td>
                <td><?php echo ($fila['rubroLocal']); ?></td>
            </tr>
            <tr>
                <td colspan="5">
                <?php
            }
            // Liberar conjunto de resultados
            mysqli_free_result($vResultado);
            // Cerrar la conexion
            mysqli_close($link);
                ?>
                </td>
            </tr>
    </table>

    <?php
    if ($total_paginas > 1) {
        for ($i = 1; $i <= $total_paginas; $i++) {
            if ($pagina == $i)
                //si muestro el índice de la página actual, no coloco enlace
                echo $pagina . " ";
            else
                //si la página no es la actual, coloco el enlace para ir a esa página
                echo "<a href='locales.php?pagina=" . $i . "'>" . $i . "</a> ";
        }
    }
    ?>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p align="center"><a href="index.html">Volver al men&uacute;</a></p>
    
</body>

</html>




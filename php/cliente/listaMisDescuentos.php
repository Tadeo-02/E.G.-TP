<?php
require_once __DIR__ . '/../main.php';

// Pagination and inputs expected from the including view
$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

if (session_status() !== PHP_SESSION_ACTIVE) session_start();
$codCliente = $_SESSION['codUsuario'] ?? null;

$tabla = '';
if (!$codCliente) {
    $tabla = '<p>No estás logueado.</p>';
    echo $tabla;
    return;
}

$conexion = conexion();

    // Determine ordering (expected from the view as a safe column expression)
    if (isset($ordenar) && $ordenar !== '') {
        $ordenar_sql = $ordenar;
        if (!preg_match('/\bASC\b|\bDESC\b/i', $ordenar_sql)) {
            if (stripos($ordenar_sql, 'fecha') !== false) {
                $ordenar_sql .= ' DESC';
            } else {
                $ordenar_sql .= ' ASC';
            }
        }
    } else {
        $ordenar_sql = 'up.fechaUsoPromo DESC';
    }

    $consulta_datos = "SELECT up.codUsoPromociones, up.codPromo, up.fechaUsoPromo, up.estado, p.textoPromo, p.fechaDesdePromo, p.fechaHastaPromo, p.diasSemana, l.nombreLocal
                        FROM uso_promociones up
                        INNER JOIN promociones p ON up.codPromo = p.codPromo
                        INNER JOIN locales l ON p.codLocal = l.codLocal
                        WHERE up.codCliente = $codCliente AND up.estado = 'Aprobada'
                        ORDER BY " . $ordenar_sql . "
                        LIMIT $inicio, $registros";

$consulta_total = "SELECT COUNT(*) FROM uso_promociones up WHERE up.codCliente = $codCliente AND up.estado = 'Aprobada'";

$datos = mysqli_query($conexion, $consulta_datos);
$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
$Npaginas = ceil($total_registros / $registros);

    if ($total_registros >= 1) {
    $tabla .= '<div class="container">';
    $tabla .= '<div class="row g-3 justify-content-center">';
    foreach ($datos as $rows) {
        $id = htmlspecialchars($rows['codUsoPromociones']);
        $texto = htmlspecialchars($rows['textoPromo']);
        $desde = htmlspecialchars($rows['fechaDesdePromo']);
        $hasta = htmlspecialchars($rows['fechaHastaPromo']);
        $nombreLocal = htmlspecialchars($rows['nombreLocal'] ?? '');
        $fechaSolicitud = htmlspecialchars($rows['fechaUsoPromo']);
        $diasSemana = $rows['diasSemana'] ?? '';
        
        // Convertir días a formato legible
        $diasMap = ['1' => 'Lun', '2' => 'Mar', '3' => 'Mié', '4' => 'Jue', '5' => 'Vie', '6' => 'Sáb', '7' => 'Dom'];
        $diasLimpios = preg_replace('/[^0-9,]/', '', $diasSemana);
        $diasArray = $diasLimpios !== '' ? explode(',', $diasLimpios) : [];
        $diasTexto = [];
        foreach ($diasArray as $dia) {
            if (isset($diasMap[$dia])) {
                $diasTexto[] = $diasMap[$dia];
            }
        }
        $diasDisponibles = !empty($diasTexto) ? implode(', ', $diasTexto) : 'No especificado';

        $tabla .= '<div class="col-12 col-md-8 col-lg-8">';
        $tabla .= '<div class="promociones">';
        $tabla .= '<div class="textContainer-promo">';
        $tabla .= '<h2>' . $texto . '</h2>';
        $tabla .= '<p class="promo-descripcion">Solicitud: ' . $fechaSolicitud . '</p>';
        $tabla .= '<p class="promo-local"><strong>Local:</strong> ' . $nombreLocal . '</p>';
        $tabla .= '<div class="promo-meta">';
        $tabla .= '<span><strong>Válido desde:</strong> ' . $desde . '</span>';
        $tabla .= '<span><strong>Hasta:</strong> ' . $hasta . '</span>';
        $tabla .= '</div>';
        $tabla .= '<p class="promo-descripcion"><strong>Días disponibles:</strong> ' . $diasDisponibles . '</p>';
        $tabla .= '</div>';
        $tabla .= '<div class="textContainer-promo-buttons">';
        $tabla .= '<form action="./php/cliente/utilizarDescuento.php" method="POST">';
        $tabla .= '<input type="hidden" name="codUsoPromociones" value="' . $id . '">';
        $tabla .= '<button type="submit" class="btn btn-primary" onclick="return confirm(\'¿Seguro que deseas usar este descuento ahora?\');">Usar descuento</button>';
        $tabla .= '</form>';
        $tabla .= '</div>';
        $tabla .= '</div>';
        $tabla .= '</div>';
    }
    $tabla .= '</div>';
    $tabla .= '</div>';
} else {
    $tabla .= '<p class="centered" style="color: red">No tienes descuentos aprobados.</p>';
}

echo $tabla;

if ($total_registros>=1 && $pagina <= $Npaginas) {
    echo paginador_tablas($pagina, $Npaginas, $url, 7);
}

mysqli_close($conexion);

?>

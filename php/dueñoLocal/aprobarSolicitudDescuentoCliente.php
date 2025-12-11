<?php 
    require_once "../main.php";

    // Now expect primary key codUsoPromociones
    $codUso = limpiar_cadena($_POST['codUsoPromociones']);
    $estado = "Aprobada";

    $conexion = conexion();

    // Obtener el codCliente asociado para actualizar la categoría luego
    $stmtGet = $conexion->prepare("SELECT codCliente FROM uso_promociones WHERE codUsoPromociones = ? LIMIT 1");
    $stmtGet->bind_param("i", $codUso);
    $stmtGet->execute();
    $res = $stmtGet->get_result();
    $row = $res->fetch_assoc();
    $codCliente = $row['codCliente'] ?? null;
    $stmtGet->close();

    $aprobar_promo = $conexion->prepare("UPDATE uso_promociones SET estado = ? WHERE codUsoPromociones = ? LIMIT 1");
    $aprobar_promo->bind_param("si", $estado, $codUso);
    $aprobar_promo->execute();

    // Actualizar categoría del cliente basado en promociones usadas
    if ($codCliente) {
        actualizarCategoriaCliente($conexion, $codCliente);
    }

    // Cerrar la conexión
    $aprobar_promo->close();
    $conexion->close();

    /**
     * Actualiza la categoría del cliente según la cantidad de promociones usadas
     * Criterios:
     * - Inicial: 0-4 promociones
     * - Medium: 5-14 promociones
     * - Premium: 15+ promociones
     */
    function actualizarCategoriaCliente($conexion, $codCliente) {
        // Contar promociones aprobadas del cliente
        $query = "SELECT COUNT(*) as total FROM uso_promociones WHERE codCliente = ? AND estado = 'Aprobada'";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $codCliente);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $row = $resultado->fetch_assoc();
        $totalPromociones = $row['total'];
        $stmt->close();
        
        // Determinar nueva categoría
        $nuevaCategoria = 'Inicial';
        if ($totalPromociones >= 15) {
            $nuevaCategoria = 'Premium';
        } elseif ($totalPromociones >= 5) {
            $nuevaCategoria = 'Medium';
        }
        
        // Actualizar categoría del cliente
        $updateCategoria = $conexion->prepare("UPDATE usuarios SET categoriaCliente = ? WHERE codUsuario = ?");
        $updateCategoria->bind_param("si", $nuevaCategoria, $codCliente);
        $updateCategoria->execute();
        $updateCategoria->close();
    }

    if (isset($_SERVER['HTTP_REFERER'])) {
        // Redireccionar al usuario a la página anterior
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // En caso de que no haya página anterior, redirigir a una página predeterminada
        header("Location: index.php");
        exit();
    }
?>
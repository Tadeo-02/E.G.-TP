<?php
require_once "../main.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name("UNR");
    session_start();
}

$codUso = limpiar_cadena($_POST['codUsoPromociones'] ?? '');
$conexion = conexion();

if (!$codUso) {
    $_SESSION['mensaje'] = 'Parámetros inválidos.';
    $redirect = $_SERVER['HTTP_REFERER'] ?? '../../index.php';
    header('Location: ' . $redirect);
    exit();
}

// Obtener uso
$stmt = $conexion->prepare("SELECT codPromo, codCliente FROM uso_promociones WHERE codUsoPromociones = ? LIMIT 1");
$stmt->bind_param("i", $codUso);
$stmt->execute();
$res = $stmt->get_result();
$uso = $res->fetch_assoc();
$stmt->close();

if (!$uso) {
    $_SESSION['mensaje'] = 'Uso de promoción no encontrado.';
    $redirect = $_SERVER['HTTP_REFERER'] ?? '../../index.php';
    header('Location: ' . $redirect);
    exit();
}

$codPromo = $uso['codPromo'];
$codCliente = $uso['codCliente'];

// Obtener días permitidos de la promoción
$stmt2 = $conexion->prepare("SELECT diasSemana FROM promociones WHERE codPromo = ? LIMIT 1");
$stmt2->bind_param("i", $codPromo);
$stmt2->execute();
$res2 = $stmt2->get_result();
$promo = $res2->fetch_assoc();
$stmt2->close();

$diasSemanaRaw = $promo['diasSemana'] ?? '';
$diasSemanaLimpios = preg_replace('/[^0-9,]/', '', $diasSemanaRaw);
$diasSemanaPermitidos = $diasSemanaLimpios !== '' ? explode(',', $diasSemanaLimpios) : [];

$hoyNumero = (int) date('N'); // 1 (Mon) .. 7 (Sun)

if (!in_array((string)$hoyNumero, array_map('strval', $diasSemanaPermitidos))) {
    $_SESSION['mensaje'] = 'La utilización del descuento no está disponible este día de la semana';
    $redirect = $_SERVER['HTTP_REFERER'] ?? '../../index.php';
    header('Location: ' . $redirect);
    exit();
}

// Marcar como utilizado
$stmtUpd = $conexion->prepare("UPDATE uso_promociones SET estado = 'Utilizado' WHERE codUsoPromociones = ? LIMIT 1");
$stmtUpd->bind_param("i", $codUso);
$stmtUpd->execute();
$stmtUpd->close();

// Actualizar categoría del cliente basado en promociones utilizadas
function actualizarCategoriaClienteUtilizados($conexion, $codCliente) {
    $query = "SELECT COUNT(*) as total FROM uso_promociones WHERE codCliente = ? AND estado = 'Utilizado'";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $codCliente);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $row = $resultado->fetch_assoc();
    $totalPromociones = $row['total'];
    $stmt->close();

    $nuevaCategoria = 'Inicial';
    if ($totalPromociones >= 15) {
        $nuevaCategoria = 'Premium';
    } elseif ($totalPromociones >= 5) {
        $nuevaCategoria = 'Medium';
    }

    $updateCategoria = $conexion->prepare("UPDATE usuarios SET categoriaCliente = ? WHERE codUsuario = ?");
    $updateCategoria->bind_param("si", $nuevaCategoria, $codCliente);
    $updateCategoria->execute();
    $updateCategoria->close();
}

if ($codCliente) {
    actualizarCategoriaClienteUtilizados($conexion, $codCliente);
}

$_SESSION['mensaje'] = 'Descuento utilizado correctamente.';
$redirect = $_SERVER['HTTP_REFERER'] ?? '../../index.php';
header('Location: ' . $redirect);
exit();

?>

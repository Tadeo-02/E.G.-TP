<?php
	require_once(__DIR__ . '/vencimientoPromociones.php');

	if (isset($_SESSION['mensaje'])) {
		echo "<script>
				alert('" . $_SESSION['mensaje'] . "');
			</script>";
		unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
	}
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

    $hoy = date("Y-m-d");

	$tabla="";
	
	// Agregar condiciones según los filtros seleccionados

	$sort = $ordenar != '' ? $ordenar : 'fechaDesdePromo';
	$codUsuario = $_SESSION['codUsuario'] ?? null; // Evita error si no está definido
	$condicionesI = [];
	$condicionesw = [];

	//if (!empty($tipoUsuario) && $codUsuario) { //agrega consulta de nombre local
	$campos="  locales.codLocal, locales.codUsuario, locales.nombreLocal, 
	promociones.codLocal, promociones.codPromo, promociones.textoPromo, promociones.categoriaCliente,
	promociones.fechaDesdePromo, promociones.fechaHastaPromo, promociones.diasSemana";
	$condicionesI[] = "INNER JOIN locales ON promociones.codLocal = locales.codLocal";

	// Verificacion segun si es dueño o cliente/UNR
	if ($tipoUsuario == 'Dueño') {
		$condicionesW[] = "locales.codUsuario = $codUsuario";
	}
	//} 
	if (!empty($localActual)) {
		$condicionesW[] = "promociones.codLocal = $localActual"; // Indico de cual tabla es el codLocal
	}

	if (!empty($diaDesde && !empty($diaHasta))) {
		$condicionesW[] = "('$diaDesde' BETWEEN fechaDesdePromo AND fechaHastaPromo OR '$diaHasta' BETWEEN fechaDesdePromo AND fechaHastaPromo OR '$diaDesde' < fechaDesdePromo AND '$diaHasta' > fechaHastaPromo)";
	} elseif (!empty($diaDesde)) {
		$condicionesW[] = "'$diaDesde' BETWEEN fechaDesdePromo AND fechaHastaPromo OR '$diaDesde' < fechaDesdePromo";
	} elseif (!empty($diaHasta)) {
		$condicionesW[] = "'$diaHasta' BETWEEN fechaDesdePromo AND fechaHastaPromo OR '$diaHasta' > fechaHastaPromo";
	}

	
	// Convertir condiciones a una cadena SQL
	if($tipoUsuario != 'Administrador') {
		$condicionesW[] = 'estadoPromo = "Activa"'; // Evitar error de SQL si no hay condiciones
	}
	else {
		$condicionesW[] = 'estadoPromo = "Pendiente"'; // Evitar error de SQL si no hay condiciones
	}
	
	$where = !empty($condicionesW) ? 'WHERE ' . implode(' AND ', $condicionesW) : '';

	$innerjoin = !empty($condicionesI) ? implode(' ', $condicionesI) : ''; 
	$select = isset($campos) ? $campos : '*';
	$orden = isset($orden) && strtoupper($orden) === 'DESC' ? 'DESC' : 'ASC';

	// Construir consultas finales
	$consulta_datos = "SELECT $select 
						FROM promociones
						$innerjoin
						$where
						ORDER BY $sort $orden
						LIMIT $inicio, $registros";

	$consulta_total = "SELECT COUNT(*) FROM promociones 
						$innerjoin 
						$where";

	$datos = mysqli_query($conexion, $consulta_datos);

	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
    
	$Npaginas = ceil($total_registros / $registros);

	// Número de filas devueltas en esta página (para calcular pag_final correctamente)
	$filas_pagina = mysqli_num_rows($datos);

	if($total_registros>=1 && $pagina<=$Npaginas){
		$pag_inicio = $inicio + 1;

		if ($tipoUsuario == '' || $tipoUsuario == "Dueño") {

			foreach($datos as $rows){ 	
				//decodifico el arreglo json
				$numerosDias = json_decode($rows['diasSemana'], true);
				if (!is_array($numerosDias)) {
					$numerosDias = [$numerosDias]; // Convertir número único en array
				}
				$arrayDiasSemana = [
					1 => 'Lunes',
					2 => 'Martes',
					3 => 'Miércoles',
					4 => 'Jueves',
					5 => 'Viernes',
					6 => 'Sábado',
					7 => 'Domingo'
				];

				$palabraDias = array_map(fn($num) => $arrayDiasSemana[$num] ?? 'Desconocido', $numerosDias);
			$tabla.=' 
			<div class="promociones">
				<div class="textContainer-promo">
					<h2>'. htmlspecialchars($rows['nombreLocal']) .'</h2>
					<p class="promo-descripcion">'. htmlspecialchars($rows['textoPromo']) . '</p>
					<div class="promo-meta">
						<span><strong>Desde:</strong> '. htmlspecialchars($rows['fechaDesdePromo']) .'</span>
						<span><strong>Hasta:</strong> '. htmlspecialchars($rows['fechaHastaPromo']) .'</span>
						<span><strong>Días:</strong> ' . htmlspecialchars(implode(', ', $palabraDias)) . '</span>
						<span><strong>Categoría:</strong> ' . htmlspecialchars($rows['categoriaCliente']) . '</span>
						<span class="promo-id">ID: ' . htmlspecialchars($rows['codPromo']) .'</span>
					</div>
				</div>
			</div>
		';  
		}
		} elseif ($tipoUsuario == "Cliente"){
			$arrayCategoriaCliente = [
				"Inicial" => 1,
				"Medium" => 2,
				"Premium" => 3,
			];
			$numeroCliente = $arrayCategoriaCliente[$_SESSION['categoriaCliente']] ?? 'Desconocido';

			foreach($datos as $rows){ 	
				//decodifico el arreglo json
				$numerosDias = json_decode($rows['diasSemana'], true);
				if (!is_array($numerosDias)) {
					$numerosDias = [$numerosDias]; // Convertir número único en array
				}
				$arrayDiasSemana = [
					1 => 'Lunes',
					2 => 'Martes',
					3 => 'Miércoles',
					4 => 'Jueves',
					5 => 'Viernes',
					6 => 'Sábado',
					7 => 'Domingo'
				];
				$palabraDias = array_map(fn($num) => $arrayDiasSemana[$num] ?? 'Desconocido', $numerosDias);

				$valorCategoria = $rows['categoriaCliente'];
				
				$numeroCategoria = $arrayCategoriaCliente[$valorCategoria] ?? 'Desconocido';

				$tabla.='
				<div class="promociones">
					<div class="textContainer-promo">
						<h2>'. htmlspecialchars($rows['nombreLocal']) .'</h2>
						<p class="promo-descripcion">'. htmlspecialchars($rows['textoPromo']) . '</p>
						<div class="promo-meta">
							<span><strong>Desde:</strong> '. htmlspecialchars($rows['fechaDesdePromo']) .'</span>
							<span><strong>Hasta:</strong> '. htmlspecialchars($rows['fechaHastaPromo']) .'</span>
							<span><strong>Días:</strong> ' . htmlspecialchars(implode(', ', $palabraDias)) . '</span>
							<span><strong>Categoría:</strong> ' . htmlspecialchars($rows['categoriaCliente']) . '</span>
							<span class="promo-id">ID: ' . htmlspecialchars($rows['codPromo']) .'</span>
						</div>
					</div>
					<div class="textContainer-promo-buttons">';
				if($numeroCategoria > $numeroCliente){
					$tabla.='
							<button type="submit"  name="botonAnashe" value="Solicitar Descuento" class="btn btn-danger" onclick="return alertar1();">Solicitar Descuento</button>
						</div>
				</div>';
				}elseif($rows['fechaDesdePromo'] > $hoy || $rows['fechaHastaPromo'] < $hoy){
						$tabla.='
							<button type="submit"  name="botonAnashe" value="Solicitar Descuento" class="btn btn-danger" onclick="return alertar2();">Solicitar Descuento</button>
						</div>
				</div>';
				}else{
					$tabla.='
							<form action="./php/cliente/saveSolicitudPromoCliente.php" method="POST">
								<input type="hidden" name="codPromo" value="'.htmlspecialchars($rows['codPromo']) .'">
								<input type="hidden" name="codUsuario" value="'.htmlspecialchars($_SESSION['codUsuario']).'">
								<button type="submit" onclick="return confirm(\'¿Seguro que quieres solicitar este Descuento?\');" name="botonAnashe" value="Solicitar Descuento" class="btn btn-success">Solicitar Descuento</button>
							</form>
						</div>
				</div>';
				}
			}
		}else{
			foreach($datos as $rows){ 	
				//decodifico el arreglo json
				$numerosDias = json_decode($rows['diasSemana'], true);
				if (!is_array($numerosDias)) {
					$numerosDias = [$numerosDias]; // Convertir número único en array
				}
				$arrayDiasSemana = [
					1 => 'Lunes',
					2 => 'Martes',
					3 => 'Miércoles',
					4 => 'Jueves',
					5 => 'Viernes',
					6 => 'Sábado',
					7 => 'Domingo'
				];
				$palabraDias = array_map(fn($num) => $arrayDiasSemana[$num] ?? 'Desconocido', $numerosDias);
				$tabla.=' 
			<div class="promociones">
				<div class="textContainer-promo">
					<h2>'. htmlspecialchars($rows['nombreLocal']) .'</h2>
					<p class="promo-descripcion">'. htmlspecialchars($rows['textoPromo']) . '</p>
					<div class="promo-meta">
						<span><strong>Desde:</strong> '. htmlspecialchars($rows['fechaDesdePromo']) .'</span>
						<span><strong>Hasta:</strong> '. htmlspecialchars($rows['fechaHastaPromo']) .'</span>
						<span><strong>Días:</strong> ' . htmlspecialchars(implode(', ', $palabraDias)) . '</span>
						<span><strong>Categoría:</strong> ' . htmlspecialchars($rows['categoriaCliente']) . '</span>
						<span class="promo-id">ID: ' . htmlspecialchars($rows['codPromo']) .'</span>
					</div>
				</div>
				<div class="textContainer-promo-buttons">
					<form action="./php/admin/aprobarPromocion.php" method="POST">
						<input type="hidden" name="codPromo" value="'.htmlspecialchars($rows['codPromo']) .'">
						<button type="submit"  name="botonAnashe" value="APROBAR Solicitud" class="btn btn-success" onclick="return aprobar();">Aprobar Solicitud</button>
					</form>
					<br>
					<form action="./php/admin/denegarPromocion.php" method="POST">
						<input type="hidden" name="codPromo" value="'. htmlspecialchars($rows['codPromo']) .'">
						<button type="submit"  name="botonAnashe" value="RECHAZAR Solicitud" class="btn btn-danger" onclick="return rechazar();">Rechazar Solicitud</button>
					</form>
					</div>
		</div>';
			}
			}
			// Calcular pag_final en base a las filas realmente devueltas
			$pag_final = $inicio + $filas_pagina;
	}
	
	// Si no hay registros, mostrar un mensaje
	else{
		if($total_registros>=1){
			$tabla.=' <table>
				<tr class="has-text-centered" >
					<td>
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para recargar el listado
						</a>
					</td>
				</tr>
			';
		}else{
			$tabla.='
				<div class="promociones">
					<div class="textContainer2">
						<tr class="has-text-centered" >
							<td>
								<p class="centered" style="color: red"><b>	No hay promociones disponibles para las fechas o locales ingresados </b></p>
							</td>
						</tr>
					</div>
                </div>
            ';
		}
	}

	$tabla.='</tbody></table>';

	//Paginador
	if($total_registros>0 && $pagina<=$Npaginas){
		$tabla.='<p style="text-align: center; color: white;">
					Mostrando promociones <strong>'. $pag_inicio .'</strong> al 
					<strong>'. $pag_final .'</strong> de un 
					<strong>total de '.$total_registros.'</strong>
				</p>';
	}

	mysqli_close($conexion);

	echo $tabla;

	if($total_registros>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}
?>
<script>
function confirmar() {
    return confirm("¿Seguro que quieres solicitar este Descuento?");
}
function alertar1() {
    return confirm("Usted no puede acceder a esta promocion porque su nivel de usuario es menor al solicitado");
}
function alertar2() {
    return confirm("Por favor, vuelva a intentarlo cuando el periodo de la promoción haya iniciado");
}
function aprobar() {
    return confirm("¿Seguro que quieres aprobar esta solicitud de descuento?");
}
function rechazar() {
    return confirm("¿Seguro que quieres rechazar esta solicitud de descuento?");
}
// Valida días permitidos antes de enviar el formulario (evita navegación durante el alert)
// handler synchronous: recibe array de dias permitidos (numeros) y devuelve boolean
function validarDiasInline(diasPermitidos) {
	try {
		const now = new Date();
		const jsDay = now.getDay(); // 0=Sunday,1=Monday,...6=Saturday
		const diaHoy = jsDay === 0 ? 7 : jsDay; // Convertir a 1-7 con Monday=1
		if (!Array.isArray(diasPermitidos)) diasPermitidos = [diasPermitidos];
		const dias = diasPermitidos.map(x => Number(x));
		if (!dias.includes(diaHoy)) {
			alert('La solicitud no está disponible este día de la semana');
			return false;
		}
		// Si está permitido, pedir confirmación final (sin recarga durante el diálogo)
		return confirm('¿Seguro que quieres solicitar este Descuento?');
	} catch (e) {
		// en caso de error, permitir el envío y dejar que el servidor valide
		return true;
	}
}
// Helper: lee el atributo data-dias del formulario y delega a validarDiasInline
function validarDiasInlineFromElement(btn) {
	try {
		const form = btn.closest('form');
		if (!form) return validarDiasInline(null);
		const raw = form.dataset.dias || form.getAttribute('data-dias') || '';
		const parsed = raw ? JSON.parse(raw) : null;
		return validarDiasInline(parsed);
	} catch (e) {
		return validarDiasInline(null);
	}
}
</script>

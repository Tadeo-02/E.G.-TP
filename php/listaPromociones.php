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
	if (!empty($diaDesde)) {
		$condicionesW[] = "'$diaDesde' BETWEEN fechaDesdePromo AND fechaHastaPromo"; // Indico fecha desde y hasta de la promo
	}
	if (!empty($diaHasta)) {
		$condicionesW[] = "'$diaHasta' BETWEEN fechaDesdePromo AND fechaHastaPromo";
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

	// Construir consultas finales
	$consulta_datos = "SELECT $select 
						FROM promociones
						$innerjoin
						$where
						ORDER BY $sort ASC
						LIMIT $inicio, $registros";

	$consulta_total = "SELECT COUNT(*) FROM promociones 
						$innerjoin 
						$where";

	$datos = mysqli_query($conexion, $consulta_datos);

	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
	
	$Npaginas = ceil($total_registros / $registros);

	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;

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
				<div class="textContainer">
					<h2> Local: '. htmlspecialchars($rows['nombreLocal']) .'	</h2>
					<h4> Id de la promoción: ' . htmlspecialchars($rows['codPromo']) .'  </h4>
					<p>	Descripción de Promoción: <b>'. htmlspecialchars($rows['textoPromo']) . '</b></p>
					<p> Fecha Desde: <b> '. htmlspecialchars($rows['fechaDesdePromo']) .  '</b></p>
					<p> Fecha Hasta: 	<b>'. htmlspecialchars($rows['fechaHastaPromo']) . ' </b></p>
					<p> Días de la semana válidos: <b>' . htmlspecialchars(implode(', ', $palabraDias)) . '</b></p>
					<p> Tipo de Cliente: <b>' . htmlspecialchars($rows['categoriaCliente']) . '</b></p>
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
					<div class="textContainer">
						<h2> Local: '. htmlspecialchars($rows['nombreLocal']) .'	</h2>
						<h4> Id de la promoción: ' . htmlspecialchars($rows['codPromo']) .'  </h4>
						<p>	Descripción de Promoción: <b>'. htmlspecialchars($rows['textoPromo']) . '</b></p>
						<p> Fecha Desde: <b> '. htmlspecialchars($rows['fechaDesdePromo']) .  '</b></p>
						<p> Fecha Hasta: 	<b>'. htmlspecialchars($rows['fechaHastaPromo']) . ' </b></p>
						<p> Días de la semana válidos: <b>' . htmlspecialchars(implode(', ', $palabraDias)) . '</b></p>
						<p> Tipo de Cliente: <b>' . htmlspecialchars($rows['categoriaCliente']) . '</b></p>
					</div>';
				if($numeroCategoria > $numeroCliente){
					$tabla.='<div class="textContainer">
							<button type="submit"  name="botonAnashe" value="Solicitar Descuento" class="btn btn-danger" onclick="return alertar1();">Solicitar Descuento</button>
					</div>
				</div>';
				}elseif($rows['fechaDesdePromo'] > $hoy){
					$tabla.='<div class="textContainer">
							<button type="submit"  name="botonAnashe" value="Solicitar Descuento" class="btn btn-danger" onclick="return alertar2();">Solicitar Descuento</button>
					</div>
				</div>';
				}else{
					$tabla.='<div class="textContainer">
							<form action="./php/cliente/saveSolicitudPromoCliente.php" method="POST">
								<input type="hidden" name="codPromo" value="'.htmlspecialchars($rows['codPromo']) .'">
								<input type="hidden" name="codUsuario" value="'.htmlspecialchars($_SESSION['codUsuario']).'">
								<button type="submit"  name="botonAnashe" value="Solicitar Descuento" class="btn btn-success" onclick="return confirmar();">Solicitar Descuento</button>
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
				<div class="textContainer">
					<h2> Local: '. htmlspecialchars($rows['nombreLocal']) .'	</h2>
					<h4> Id de la promoción: ' . htmlspecialchars($rows['codPromo']) .'  </h4>
					<p>	Descripción de Promoción: <b>'. htmlspecialchars($rows['textoPromo']) . '</b></p>
					<p> Fecha Desde: <b> '. htmlspecialchars($rows['fechaDesdePromo']) .  '</b></p>
					<p> Fecha Hasta: 	<b>'. htmlspecialchars($rows['fechaHastaPromo']) . ' </b></p>
					<p> Días de la semana válidos: <b>' . htmlspecialchars(implode(', ', $palabraDias)) . '</b></p>
					<p> Tipo de Cliente: <b>' . htmlspecialchars($rows['categoriaCliente']) . '</b></p>
				</div>
				<div class="textContainer">
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
		$contador++;
		$pag_final=$contador-1;
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
</script>

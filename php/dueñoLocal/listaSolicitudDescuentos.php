<?php
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	
	$tabla="";

	$codDueño = isset($_SESSION['codUsuario']) ? $_SESSION['codUsuario'] : '';
	//Armar consulta
	$campos="uso_promociones.codUsoPromociones, uso_promociones.codCliente, uso_promociones.codPromo, uso_promociones.fechaUsoPromo, uso_promociones.estado, promociones.codLocal, promociones.codPromo, promociones.textoPromo, promociones.categoriaCliente, promociones.fechaDesdePromo, promociones.fechaHastaPromo, promociones.diasSemana, usuarios.nombreUsuario, usuarios.codUsuario, usuarios.categoriaCliente, locales.codLocal, locales.codUsuario, locales.nombreLocal";
	$condicionesI = ["INNER JOIN promociones ON promociones.codPromo = uso_promociones.codPromo 
                   INNER JOIN usuarios ON uso_promociones.codCliente = usuarios.codUsuario 
                   INNER JOIN locales ON locales.codLocal = promociones.codLocal"];

	$condicionesW = [];
	$tipos = '';
	$parametros = [];
	$condicionesW[] = "locales.codUsuario = ?";
	$tipos .= 's';
	$parametros[] = $codDueño;
	$condicionesW[] = "uso_promociones.estado = 'Pendiente'";
	$where = !empty($condicionesW) ? 'WHERE ' . implode(' AND ', $condicionesW) : '';

	$innerjoin = !empty($condicionesI) ? implode(' ', $condicionesI) : '';
	$select = isset($campos) ? $campos : '*';

	// Construir consultas finales
	$consulta_datos = "SELECT $select 
						FROM uso_promociones 
						$innerjoin
						$where 
						ORDER BY $ordenar ASC 
						LIMIT $inicio, $registros";

	$consulta_total = "SELECT COUNT(*) FROM uso_promociones 
						$innerjoin 
						$where";

	$stmtDatos = $conexion->prepare($consulta_datos);
	if (!empty($parametros)) {
		$stmtDatos->bind_param($tipos, ...$parametros);
	}
	$stmtDatos->execute();
	$datos = $stmtDatos->get_result();
	$stmtDatos->close();

	$stmtTotal = $conexion->prepare($consulta_total);
	if (!empty($parametros)) {
		$stmtTotal->bind_param($tipos, ...$parametros);
	}
	$stmtTotal->execute();
	$total_registros = $stmtTotal->get_result()->fetch_row()[0];
	$stmtTotal->close();
	$Npaginas = ceil($total_registros / $registros);
	//Mostrar solicitud de Descuentos
	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		$tabla =' <div class="wrapper wrapperSolDesc">
					<table class="reporte">
						<tr class="reporteRow">
							<th class="reporteHeading">
								<a class="linkTabla" href="index.php?vista=discountRequest&sortBy=uso_promociones.fechaUsoPromo">Fecha solicitud ↓</a>
							</th>
							<th class="reporteHeading">
								<a class="linkTabla" href="index.php?vista=discountRequest&sortBy=uso_promociones.codCliente">Cod Cliente ↓</a>
							</th>
							<th class="reporteHeading">
								<a class="linkTabla" href="index.php?vista=discountRequest&sortBy=usuarios.nombreUsuario">Mail Cliente ↓</a>	
							</th>
							<th class="reporteHeading">
								<a class="linkTabla" href="index.php?vista=discountRequest&sortBy=uso_promociones.codPromo">Código Promoción ↓</a>
							</th>
							<th class="reporteHeading">
								<a class="linkTabla" href="index.php?vista=discountRequest&sortBy=promociones.textoPromo">Promoción ↓</a>
							</th>
							<th class="reporteHeading">
								<a class="linkTabla" href="index.php?vista=discountRequest&sortBy=locales.codLocal">Código Local ↓</a>
							</th>
							<th class="reporteHeading">
								<a class="linkTabla" href="index.php?vista=discountRequest&sortBy=locales.nombreLocal">Local ↓</a>
							</th>
							<th class="reporteHeading"></th>
						</tr>';
		foreach($datos as $rows){ 
			$codUso = $rows['codUsoPromociones'];
			$codCliente = $rows['codCliente'];
			$codPromo = $rows['codPromo'];
			$stmtCont = $conexion->prepare("SELECT COUNT(*) FROM uso_promociones WHERE estado = 'Aprobada' AND codPromo = ?");
			$stmtCont->bind_param("s", $codPromo);
			$stmtCont->execute();
			$stmtCont->bind_result($count);
			$stmtCont->fetch();
			$fila = [$count];
			$stmtCont->close();
			$nombreUsuario = $rows['nombreUsuario'];
			$codUsuario = $rows['codUsuario'];
			$nombreLocal = $rows['nombreLocal'];
			$tabla.='<tr class="reporteRow">
						<td data-cell="Fecha Uso" class="reporteContent">'.htmlspecialchars($rows['fechaUsoPromo']).'</td>
						<td data-cell="Código Cliente" class="reporteContent">'. htmlspecialchars($rows['codCliente']) . '</td>
						<td data-cell="Promoción" class="reporteContent">'.htmlspecialchars($rows['nombreUsuario']).'</td>
						<td data-cell="Código Promo" class="reporteContent">'. htmlspecialchars($rows['codPromo']) .'</td>
						<td data-cell="Texto Promo" class="reporteContent">'. htmlspecialchars($rows['textoPromo']) .'</td>
						<td data-cell="Código Local" class="reporteContent">'. htmlspecialchars($rows['codLocal']) .'</td>
						<td data-cell="Nombre Local" class="reporteContent">'. htmlspecialchars($rows['nombreLocal']) .'</td>
						<td data-cell="Aceptar/Rechazar" class="botonesTD reporteContent" style="width: 25%;">
							<div class="formContainerSolicitud">							
								<form action="./php/dueñoLocal/aprobarSolicitudDescuentoCliente.php" method="POST">
									<input type="hidden" name="codUsoPromociones" value="'.htmlspecialchars($codUso) .'">
									<input type="hidden" name="email" value="' . htmlspecialchars($nombreUsuario) . '"> <br>
									<input type="hidden" name="asunto" value="Solicitud de Descuento NOVA SHOPPING"> <br>
									<input type="hidden" name="mensaje" value="Su solicitud de descuento ha sido ACEPTADA."> <br>
									<button type="submit" name="botonAnashe" class="btn btn-success btnTabla" value="Aceptar Solicitud" onclick="return confirmar();">Aceptar</button>
								</form>							
								<form action="./php/dueñoLocal/denegarSolicitudDescuentoCliente.php" method="POST">
									<input type="hidden" name="codUsoPromociones" value="'.htmlspecialchars($codUso) .'">
									<input type="hidden" name="email" value="' . htmlspecialchars($nombreUsuario) . '"> <br>
									<input type="hidden" name="asunto" value="Solicitud de Descuento NOVA SHOPPING"> <br>
									<input type="hidden" name="mensaje" value="Su solicitud de descuento ha sido RECHAZADA."> <br>
									<button type="submit" name="botonAnashe" value="Denegar Solicitud" class="btn btn-danger btnTabla" onclick="return rechazar();">Denegar</button>
								</form>
							</div>
						</td>
					</tr>';
            
            $contador++;
		}
		$pag_final=$contador-1;
	}else{
		// Si no hay registros, mostrar un mensaje
		if($total_registros>=1){
			$tabla.=' <table>
				<tr class="has-text-centered" >
					<td>
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4		Haga clic acá para recargar el listado>
                    </td>
				</tr>
			';
		}else{
			$tabla.='
				<tr class="has-text-centered" >
					<td>
						<p class="centered" style="color: red">	No se ha utilizado ningún descuento </p>
					</td>
				</tr>
			';
		}
	}

	$tabla.='</table>	
        </div>
	</tbody></table>';

	//Paginador
	if($total_registros>0 && $pagina<=$Npaginas){
		$tabla.='<p style="text-align: center; color: white;">
    		Mostrando Solicitudes de Cuenta de dueño <strong>'. $pag_inicio .'</strong> al 
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
		return confirm("¿Seguro que quieres aceptar esta solicitud?");
	}

	function rechazar() {
		return confirm("¿Seguro que quieres rechazar esta solicitud?");
	}
</script>



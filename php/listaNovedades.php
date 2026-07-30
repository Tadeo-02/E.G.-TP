<?php
	$conexion=conexion();
	
	// FECHA HOY
	$hoy = date("Y-m-d");

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$inicio = intval($inicio);
	$registros = intval($registros);
	
	$tabla="";
	
	// Verificar si el usuario está logueado y obtener su categoría
	$categoriaCliente = isset($_SESSION['categoriaCliente']) ? $_SESSION['categoriaCliente'] : null;
	$tipoUsuario = isset($_SESSION['tipoUsuario']) ? $_SESSION['tipoUsuario'] : '';
	
	//Consultas de acuerdo a la categoria de cliente
	if($categoriaCliente == "Medium"){
		$stmt_datos = $conexion->prepare("SELECT * FROM novedades WHERE (? BETWEEN fechaDesdeNovedad AND fechaHastaNovedad) AND (tipoCliente = ? OR tipoCliente = ?) ORDER BY fechaDesdeNovedad DESC, codNovedad DESC LIMIT ?, ?");
		$inicial = 'Inicial';
		$medium = 'Medium';
		$stmt_datos->bind_param("sssii", $hoy, $inicial, $medium, $inicio, $registros);
		$stmt_datos->execute();
		$datos = $stmt_datos->get_result();
		$stmt_datos->close();

		$stmt_total = $conexion->prepare("SELECT COUNT(*) FROM novedades WHERE (? BETWEEN fechaDesdeNovedad AND fechaHastaNovedad) AND (tipoCliente = ? OR tipoCliente = ?)");
		$stmt_total->bind_param("sss", $hoy, $inicial, $medium);
		$stmt_total->execute();
		$total_registros = $stmt_total->get_result()->fetch_row()[0];
		$stmt_total->close();

	}elseif($categoriaCliente == "Inicial"){
		$stmt_datos = $conexion->prepare("SELECT * FROM novedades WHERE (? BETWEEN fechaDesdeNovedad AND fechaHastaNovedad) AND tipoCliente = ? ORDER BY fechaDesdeNovedad DESC, codNovedad DESC LIMIT ?, ?");
		$inicial = 'Inicial';
		$stmt_datos->bind_param("ssii", $hoy, $inicial, $inicio, $registros);
		$stmt_datos->execute();
		$datos = $stmt_datos->get_result();
		$stmt_datos->close();

		$stmt_total = $conexion->prepare("SELECT COUNT(*) FROM novedades WHERE (? BETWEEN fechaDesdeNovedad AND fechaHastaNovedad) AND tipoCliente = ?");
		$stmt_total->bind_param("ss", $hoy, $inicial);
		$stmt_total->execute();
		$total_registros = $stmt_total->get_result()->fetch_row()[0];
		$stmt_total->close();

	}else{
		$stmt_datos = $conexion->prepare("SELECT * FROM novedades WHERE ? BETWEEN fechaDesdeNovedad AND fechaHastaNovedad ORDER BY fechaDesdeNovedad DESC, codNovedad DESC LIMIT ?, ?");
		$stmt_datos->bind_param("sii", $hoy, $inicio, $registros);
		$stmt_datos->execute();
		$datos = $stmt_datos->get_result();
		$stmt_datos->close();

		$stmt_total = $conexion->prepare("SELECT COUNT(*) FROM novedades WHERE ? BETWEEN fechaDesdeNovedad AND fechaHastaNovedad");
		$stmt_total->bind_param("s", $hoy);
		$stmt_total->execute();
		$total_registros = $stmt_total->get_result()->fetch_row()[0];
		$stmt_total->close();

	}
	$Npaginas = ceil($total_registros / $registros);

	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		if($tipoUsuario == "Administrador"){
			foreach($datos as $rows){ 
				$codNovedad = $rows['codNovedad'];
                $tabla.='<div class="novedades">
							<div class="textContainer-novedad">
									<h2>'. htmlspecialchars($rows['textoNovedad']) . '</h2>
									<div class="novedad-meta">
										<span><strong>Desde:</strong> '. htmlspecialchars($rows['fechaDesdeNovedad']) .'</span>
										<span><strong>Hasta:</strong> '. htmlspecialchars($rows['fechaHastaNovedad']) .'</span>
										<span><strong>Tipo:</strong> '. htmlspecialchars($rows['tipoCliente']) .'</span>
									</div>
							</div>
			
							<div class="textContainer-novedad-buttons">
								<form action="index.php?vista=novedadesUpdate" method="POST">
									<input type="hidden" name="codNovedad" value="'.htmlspecialchars($codNovedad) .'">
									<input type="submit" name="botonAnashe" class="btn btn-warning" value="Modificar Novedad">
								</form>
								<br>
								<form action="./php/admin/eliminarNovedades.php" method="POST">
									<input type="hidden" name="codNovedad" value="'.htmlspecialchars($codNovedad) .'">
									<input type="hidden" name="dato" value="valor">
									<button type="submit"  name="botonAnashe" value="Eliminar Novedad" class="btn btn-danger" onclick="return confirmar();">Eliminar Novedad</button>
								
								</form>
							</div>
						</div>';
				$contador++;
			}
		}else{
			foreach($datos as $rows){ 
				$codNovedad = $rows['codNovedad'];
                $tabla.='<div class="novedades">
							<div class="textContainer-novedad">
									<h2>'. htmlspecialchars($rows['textoNovedad']) . '</h2>
									<div class="novedad-meta">
										<span><strong>Desde:</strong> '. htmlspecialchars($rows['fechaDesdeNovedad']) .'</span>
										<span><strong>Hasta:</strong> '. htmlspecialchars($rows['fechaHastaNovedad']) .'</span>
										<span><strong>Tipo:</strong> '. htmlspecialchars($rows['tipoCliente']) .'</span>
									</div>
							</div>
						</div>';
				$contador++;
			}
		}

		$pag_final=$contador-1;
	}else{
		if($total_registros>=1){
			$tabla.=' <table>
				<tr class="has-text-centered" >
					<td>
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para recargar el listado
						</a>
					</td>
				</tr>';
		} else {
			$tabla.='
				<tr class="has-text-centered" >
					<td>
						<p class="centered" style="color: red">	No hay novedades disponibles </p>
					</td>
				</tr>';
		}
	}
	
	$tabla.='</tbody></table>';

	// Si no hay registros, mostrar un mensaje
	if($total_registros>0 && $pagina<=$Npaginas){
		$tabla.='<p style="text-align: center; color: white;">
    		Mostrando novedades <strong>'. $pag_inicio .'</strong> al 
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
    return confirm("¿Seguro que quieres eliminar esta Novedad?");
}
</script>
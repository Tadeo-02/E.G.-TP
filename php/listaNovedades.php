<?php
	$conexion=conexion();
	
	// FECHA HOY
	$hoy = date("Y-m-d");

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	
	$tabla="";
	
	// Verificar si el usuario está logueado y obtener su categoría
	$categoriaCliente = isset($_SESSION['categoriaCliente']) ? $_SESSION['categoriaCliente'] : 'Inicial';
	$tipoUsuario = isset($_SESSION['tipoUsuario']) ? $_SESSION['tipoUsuario'] : '';
	
	//Consultas de acuerdo a la categoria de cliente
	if($categoriaCliente == "Medium"){
		$consulta_datos = "SELECT * FROM novedades 
					WHERE (DATE ('$hoy') BETWEEN fechaDesdeNovedad AND fechaHastaNovedad) AND (tipoCliente = 'Inicial' OR tipoCliente = 'Medium')
					ORDER BY fechaDesdeNovedad DESC, codNovedad DESC 
					LIMIT $inicio, $registros";
		$consulta_total = "SELECT COUNT(*) FROM novedades WHERE (DATE ('$hoy') BETWEEN fechaDesdeNovedad AND fechaHastaNovedad) AND (tipoCliente = 'Inicial' OR tipoCliente = 'Medium') ";

	}elseif($categoriaCliente == "Inicial"){
		$consulta_datos = "SELECT * FROM novedades 
					WHERE (DATE ('$hoy') BETWEEN fechaDesdeNovedad AND fechaHastaNovedad) AND tipoCliente = 'Inicial'
					ORDER BY fechaDesdeNovedad DESC, codNovedad DESC 
					LIMIT $inicio, $registros";
		$consulta_total = "SELECT COUNT(*) FROM novedades WHERE (DATE ('$hoy') BETWEEN fechaDesdeNovedad AND fechaHastaNovedad) AND tipoCliente = 'Inicial' ";

	}else{
		$consulta_datos = "SELECT * FROM novedades 
                   WHERE DATE('$hoy') BETWEEN fechaDesdeNovedad AND fechaHastaNovedad 
                   ORDER BY fechaDesdeNovedad DESC, codNovedad DESC 
                   LIMIT $inicio, $registros";
		$consulta_total = "SELECT COUNT(*) FROM novedades WHERE DATE('$hoy') BETWEEN fechaDesdeNovedad AND fechaHastaNovedad ";

	}
	
	$datos = mysqli_query($conexion, $consulta_datos);

	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
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
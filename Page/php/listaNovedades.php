<?php
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

	$tabla="";

	// Agregar condiciones según los filtros seleccionados

	$codUsuario = $_SESSION['codUsuario'] ?? null; // Evita error si no está definido

    $consulta_filtro = "SELECT * FROM novedades";

    $novedades = mysqli_query($conexion, $consulta_filtro);

	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_filtro))[0];
	
	$Npaginas = ceil($total_registros / $registros);

	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		
		foreach($novedades as $rows){ 	
            $tabla.=' 
				<div class="promociones">
						<div class="textContainer">
							<h2> Novedad: '. htmlspecialchars($rows['textoNovedad']) .'	</h2>
							<h4> Id de la Novedad: ' . htmlspecialchars($rows['codNovedad']) .'  </h4>
							<p> Fecha Desde Novedad: <b> '. htmlspecialchars($rows['fechaDesdeNovedad']) .  '</b></p>
							<p> Fecha Hasta Novedad: 	<b>'. htmlspecialchars($rows['fechaHastaNovedad']) . ' </b></p>
							<p> Tipo de Cliente válido para Novedad: <b>	'. htmlspecialchars($rows['tipoUsuario']) .  '</b></p>
						</div>
                </div>
            ';
            $contador++;
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
				</tr>
			';
		}else{
			$tabla.='
				<div class="promociones">
					<div class="textContainer2">
						<tr class="has-text-centered" >
							<td>
								<p class="centered" style="color: red"><b>	No hay novedades disponibles para las fechas o locales ingresados </b></p>
							</td>
						</tr>
					</div>
                </div>
            ';
		}
	}


	$tabla.='</tbody></table>';

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


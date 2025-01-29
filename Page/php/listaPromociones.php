<?php
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

	$tabla="";

	if (!empty($diaDesde) && !empty($diaHasta)) {
		$consulta_datos="SELECT * FROM promociones  
						 WHERE fechaDesdePromo BETWEEN '$diaDesde' AND '$diaHasta'
						 OR fechaHastaPromo BETWEEN '$diaDesde' AND '$diaHasta'
						 ORDER BY fechaDesdePromo ASC 
						 LIMIT $inicio, $registros";
	
		$consulta_total="SELECT COUNT(*) FROM promociones 
						 WHERE fechaDesdePromo BETWEEN '$diaDesde' AND '$diaHasta'
						 OR fechaHastaPromo BETWEEN '$diaDesde' AND '$diaHasta'";
	} 
	elseif (!empty($diaDesde)) {
		$consulta_datos="SELECT * FROM promociones  
						 WHERE fechaDesdePromo >= '$diaDesde' 
						 ORDER BY fechaDesdePromo ASC 
						 LIMIT $inicio, $registros";
	
		$consulta_total="SELECT COUNT(*) FROM promociones 
						 WHERE fechaDesdePromo >= '$diaDesde'";
	} 
	elseif (!empty($diaHasta)) {
		$consulta_datos="SELECT * FROM promociones  
						 WHERE fechaHastaPromo <= '$diaHasta' 
						 ORDER BY fechaDesdePromo ASC 
						 LIMIT $inicio, $registros";
	
		$consulta_total="SELECT COUNT(*) FROM promociones 
						 WHERE fechaHastaPromo <= '$diaHasta'";
	} 
	else {    
		$consulta_datos = "SELECT * FROM promociones 
						   ORDER BY fechaDesdePromo 
						   LIMIT $inicio, $registros";
	
		$consulta_total = "SELECT COUNT(*) FROM promociones";
	}
	
	

	$datos = mysqli_query($conexion, $consulta_datos);

	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
	
	$Npaginas = ceil($total_registros / $registros);

	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){ 						
			$tabla.=' 
				<div class="promociones">
						<div class="textContainer2">
							<h4> Id de la promoción:' . htmlspecialchars($rows['codPromo']) .'  </h4>
							<p>	Descripción de Promoción: <b>'. htmlspecialchars($rows['textoPromo']) . '</b></p>
							<p> Fecha Desde Promo: <b> '. htmlspecialchars($rows['fechaDesdePromo']) .  '</b></p>
							<p> Fecha Hasta Promo: 	<b>'. htmlspecialchars($rows['fechaHastaPromo']) . ' </b></p>
							<p> Días de la semana de la promoción: <b>	'. htmlspecialchars($rows['diasSemana']) .  '</b></p>
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
				<tr class="has-text-centered" >
					<td>
						<p class="centered" style="color: red">	No hay promociones disponibles para las fechas o locales ingresados </p>
					</td>
				</tr>
			';
		}
	}


	$tabla.='</tbody></table>';

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

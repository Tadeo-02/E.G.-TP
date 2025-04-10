<?php
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	
	$tabla="";
	
	$codDueño = isset($_SESSION['codUsuario']) ? $_SESSION['codUsuario'] : '';
	$tipoUsuario = isset($_SESSION['tipoUsuario']) ? $_SESSION['tipoUsuario'] : '';

	$campos="uso_promociones.codCliente, uso_promociones.codPromo, uso_promociones.fechaUsoPromo, uso_promociones.estado, promociones.codLocal, promociones.codPromo, promociones.textoPromo, promociones.categoriaCliente, promociones.fechaDesdePromo, promociones.fechaHastaPromo, promociones.diasSemana, locales.codLocal, locales.codUsuario, locales.nombreLocal";

	if($tipoUsuario == "Dueño"){
		$condicionesW[] = "locales.codUsuario = $codDueño";
	}
	$condicionesW[] = "uso_promociones.estado = 'Aprobada'";
	$where = !empty($condicionesW) ? 'WHERE ' . implode(' AND ', $condicionesW) : '';

	$innerjoin = "INNER JOIN uso_promociones ON promociones.codPromo = uso_promociones.codPromo  
                   INNER JOIN locales ON locales.codLocal = promociones.codLocal";
	$select = isset($campos) ? $campos : '*';

	// Construir consultas finales
	$consulta_datos = "SELECT DISTINCT promociones.codPromo, $select 
						FROM promociones 
						$innerjoin
						$where 
						ORDER BY locales.codLocal ASC 
						LIMIT $inicio, $registros";

	$consulta_total = "SELECT COUNT(DISTINCT promociones.codPromo) FROM promociones 
						$innerjoin 
						$where";
                        
	$datos = mysqli_query($conexion, $consulta_datos);
	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
	$Npaginas = ceil($total_registros / $registros);
	
	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		$tabla =' <div class="">
					<table>
						<thead>
							<tr>
								<th>Promoción</th>
								<th>Código Promoción</th>
								<th>Local</th>
								<th>Código Local</th>
								<th>Usos</th>
							</tr>
						</thead>
		';
		foreach($datos as $rows){ 
			$codCliente = $rows['codCliente'];
			$codPromo = $rows['codPromo'];
            $consulta_contador = "SELECT COUNT(*) FROM uso_promociones WHERE estado = 'Aprobada' AND  codPromo = $codPromo";
            $datosContador = mysqli_query($conexion, $consulta_contador);
            $fila = mysqli_fetch_row($datosContador);
			$tabla.=' 
							<tbody>
								<tr class="has-text-centered" >
									<td>'.$rows['textoPromo'].'</td>
									<td>'.$rows['codPromo'].'</td>
									<td>'.$rows['nombreLocal'].'</td>
									<td>'.$rows['codLocal'].'</td>
									<td>'.$fila[0].'</td>
								</tr>
			';
            
            $contador++;
		}
		$pag_final=$contador-1;
	}else{
		if($total_registros>=1){
			$tabla.=' <table>
				<tr class="has-text-centered" >
					<td>
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4		Haga clic acá para recargar el listado
                    </
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

	$tabla.='</tbody>
			</table>	
        		</div>
	</tbody></table>';

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
    return confirm("¿Seguro que quieres rechazar esta solicitud?");
}
</script>


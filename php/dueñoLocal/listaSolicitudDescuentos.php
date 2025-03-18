<?php
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	
	$tabla="";
	
	$codDueño = isset($_SESSION['codUsuario']) ? $_SESSION['codUsuario'] : '';

	$campos="uso_promociones.codCliente, uso_promociones.codPromo, uso_promociones.fechaUsoPromo, uso_promociones.estado, promociones.codLocal, promociones.codPromo, promociones.textoPromo, promociones.categoriaCliente, promociones.fechaDesdePromo, promociones.fechaHastaPromo, promociones.diasSemana, usuarios.nombreUsuario, usuarios.codUsuario, usuarios.categoriaCliente, locales.codLocal, locales.codUsuario, locales.nombreLocal";
	$condicionesI[] = "INNER JOIN promociones ON promociones.codPromo = uso_promociones.codPromo 
                   INNER JOIN usuarios ON uso_promociones.codCliente = usuarios.codUsuario 
                   INNER JOIN locales ON locales.codLocal = promociones.codLocal";

	$condicionesW[] = "locales.codUsuario = $codDueño"; // Indico de cual tabla es el codLocal
	$condicionesW[] = "uso_promociones.estado = 'Pendiente'"; // Indico de cual tabla es el codLocal
	$where = !empty($condicionesW) ? 'WHERE ' . implode(' AND ', $condicionesW) : '';

	$innerjoin = !empty($condicionesI) ? implode(' ', $condicionesI) : ''; // No poner 'INNER JOIN' directamente aca
	$select = isset($campos) ? $campos : '*';

	// Construir consultas finales
	$consulta_datos = "SELECT $select 
						FROM uso_promociones 
						$innerjoin
						$where 
						ORDER BY fechaUsoPromo ASC 
						LIMIT $inicio, $registros";

	$consulta_total = "SELECT COUNT(*) FROM uso_promociones 
						$innerjoin 
						$where";

	$datos = mysqli_query($conexion, $consulta_datos);
	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
	$Npaginas = ceil($total_registros / $registros);
	
	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){ 
			$codCliente = $rows['codCliente'];
			$codPromo = $rows['codPromo'];
			$nombreUsuario = $rows['nombreUsuario'];
			$tabla.=' 
				<div class="locales col-12 col-md-4">
					<div class="textContainer">
					<p> El cliente ... '. htmlspecialchars($rows['nombreUsuario']) . ' (COD '. htmlspecialchars($rows['codCliente']) . ') ... <br> desea solicitar el descuento '. htmlspecialchars($rows['textoPromo']) . ' (COD '. htmlspecialchars($rows['codPromo']) . ')
					<br> del local '. htmlspecialchars($rows['nombreLocal']) . ' (COD '. htmlspecialchars($rows['codLocal']) . ') 
					</p>
					</div>
                	<div class="textContainer col-12 col-md-4">
						<form action="./php/dueñoLocal/aprobarSolicitudDescuentoCliente.php" method="POST">
							<input type="hidden" name="codCliente" value="'.htmlspecialchars($codCliente) .'">
							<input type="hidden" name="codPromo" value="'.htmlspecialchars($codPromo) .'">
							<input type="hidden" name="email" value="' . htmlspecialchars($nombreUsuario) . '"> <br>
							<input type="hidden" name="asunto" value="Solicitud de Descuento NOVA SHOPPING"> <br>
							<input type="hidden" name="mensaje" value="Su solicitud de descuento ha sido ACEPTADA."> <br>
							<button type="submit" name="botonAnashe" class="btn btn-success" value="Aceptar Solicitud" onclick="return confirmar();">Aceptar Solicitud</button>
						</form>
						<br>
						<br>
						<form action="./php/dueñoLocal/denegarSolicitudDescuentoCliente.php" method="POST">
							<input type="hidden" name="codCliente" value="'.htmlspecialchars($codCliente) .'">
							<input type="hidden" name="codPromo" value="'.htmlspecialchars($codPromo) .'">
							<input type="hidden" name="email" value="' . htmlspecialchars($nombreUsuario) . '"> <br>
							<input type="hidden" name="asunto" value="Solicitud de Descuento NOVA SHOPPING"> <br>
							<input type="hidden" name="mensaje" value="Su solicitud de descuento ha sido RECHAZADA."> <br>
							<button type="submit" name="botonAnashe" value="Denegar Solicitud" class="btn btn-danger" onclick="return rechazar();">Denegar Solicitud</button>
						</form>
                    </div>	
        		</div>';
            

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
						<p class="centered" style="color: red">	No hay solicitudes de promociones disponibles </p>
					</td>
				</tr>
			';
		}
	}

	$tabla.='</tbody></table>';

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





<?php
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

	$tabla="";

	// Agregar condiciones según los filtros seleccionados

	$codUsuario = $_SESSION['codUsuario'] ?? null; // Evita error si no está definido
	$condicionesI = [];
	$condicionesw = [];
	//? Problema con el if
	//if (!empty($tipoUsuario) && $codUsuario) { //agregp consulta de nombre local
	$campos="  locales.codLocal, locales.codUsuario, locales.nombreLocal, 
	promociones.codLocal, promociones.codPromo, promociones.textoPromo, 
	promociones.fechaDesdePromo, promociones.fechaHastaPromo, promociones.diasSemana";
	$condicionesI[] = "INNER JOIN locales ON promociones.codLocal = locales.codLocal"; //Agregar INNER JOIN
	// if para funcione segun si es dueño o cliente/UNR
	if ($tipoUsuario == 'Dueño') {
		$condicionesW[] = "locales.codUsuario = $codUsuario";
		}
	//} 
	if (!empty($localActual)) {
		$condicionesW[] = "promociones.codLocal = $localActual"; // Indico de cual tabla es el codLocal
	}
	if (!empty($diaDesde)) {
		$condicionesW[] = "'$diaDesde' BETWEEN fechaDesdePromo AND fechaHastaPromo";
	}
	if (!empty($diaHasta)) {
		$condicionesW[] = "'$diaHasta' BETWEEN fechaDesdePromo AND fechaHastaPromo";
	}
	
	
	// Convertir condiciones a una cadena SQL
	if($tipoUsuario != 'Administrador') {
		$condicionesW[] = 'estadoPromo = "Activa"'; // Evitar error de SQL si no hay condiciones

	}
	else 
	{
		$condicionesW[] = 'estadoPromo = "Pendiente"'; // Evitar error de SQL si no hay condiciones
		// $where = 'WHERE estadoPromo = "Pendiente"';
		// if (!empty($condicionesW)) {
		// 	$where .= ' OR (' . implode(' AND ', $condicionesW) . ')';
		// }
	}
	
	$where = !empty($condicionesW) ? 'WHERE ' . implode(' AND ', $condicionesW) : '';

	

	$innerjoin = !empty($condicionesI) ? implode(' ', $condicionesI) : ''; // No poner 'INNER JOIN' directamente aquí
	$select = isset($campos) ? $campos : '*';

	// Construir consultas finales
	$consulta_datos = "SELECT $select 
						FROM promociones 
						$innerjoin
						$where 
						ORDER BY fechaDesdePromo ASC 
						LIMIT $inicio, $registros
						";



	
	$consulta_total = "SELECT COUNT(*) FROM promociones 
						$innerjoin 
						$where";

	$datos = mysqli_query($conexion, $consulta_datos);


	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
	
	$Npaginas = ceil($total_registros / $registros);

	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		
		foreach($datos as $rows){ 	

			if ($tipoUsuario != "Administrador" ){
				$tabla.=' 

				<div class="promociones">
						<div class="textContainer">
							<h2> Local: '. htmlspecialchars($rows['nombreLocal']) .'	</h2>
							<h4> Id de la promoción: ' . htmlspecialchars($rows['codPromo']) .'  </h4>
							<p>	Descripción de Promoción: <b>'. htmlspecialchars($rows['textoPromo']) . '</b></p>
							<p> Fecha Desde Promo: <b> '. htmlspecialchars($rows['fechaDesdePromo']) .  '</b></p>
							<p> Fecha Hasta Promo: 	<b>'. htmlspecialchars($rows['fechaHastaPromo']) . ' </b></p>
							<p> Días de la semana de la promoción: <b>	'. htmlspecialchars($rows['diasSemana']) .  '</b></p>
						</div>
                </div>
            ';
			}
			else{
				$tabla.=' 

				<div class="promocionesAdmin">
						<div class="textContainer">
							<h2> Local: '. htmlspecialchars($rows['nombreLocal']) .'	</h2>
							<h4> Id de la promoción: ' . htmlspecialchars($rows['codPromo']) .'  </h4>
							<p>	Descripción de Promoción: <b>'. htmlspecialchars($rows['textoPromo']) . '</b></p>
							<p> Fecha Desde Promo: <b> '. htmlspecialchars($rows['fechaDesdePromo']) .  '</b></p>
							<p> Fecha Hasta Promo: 	<b>'. htmlspecialchars($rows['fechaHastaPromo']) . ' </b></p>
							<p> Días de la semana de la promoción: <b>	'. htmlspecialchars($rows['diasSemana']) .  '</b></p>
						</div>
						 <div class="textContainer">
                        <form action="./php/admin/aprobarPromocion.php" method="POST">
                            <input type="hidden" name="codPromo" value="'.htmlspecialchars($rows['codPromo']) .'">
							<input type="hidden" name="dato" value="valor">
                            <button type="submit"  name="botonAnashe" value="APROBAR Solicitud" class="btn btn-success" onclick="return confirmar();">APROBAR Solicitud</button>
                        </form>
                        <br>
                        <br>
                        <form action="./php/admin/denegarPromocion.php" method="POST">
                            <input type="hidden" name="codPromo" value="'. htmlspecialchars($rows['codPromo']) .'">
							<input type="hidden" name="dato" value="valor">
                            <button type="submit"  name="botonAnashe" value="RECHAZAR Solicitud" class="btn btn-danger" onclick="return confirmar();">RECHAZAR Solicitud</button>
                        </form>
                        </div>
                </div>

            ';
			}

			

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
								<p class="centered" style="color: red"><b>	No hay promociones disponibles para las fechas o locales ingresados </b></p>
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
    return confirm("¿Seguro que quieres eliminar este Local?");
}
</script>

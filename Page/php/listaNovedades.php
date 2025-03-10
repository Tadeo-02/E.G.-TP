<?php
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	
	//? FECHA HOY
	$hoy = date("Y-m-d");

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	
	$tabla="";

	$codUsuario = $_SESSION['codUsuario'] ?? null; // Evita error si no está definido
	
	$consulta_datos = "SELECT * FROM novedades WHERE DATE('$hoy') BETWEEN fechaDesdeNovedad AND fechaHastaNovedad  ORDER BY fechaDesdeNovedad DESC LIMIT $inicio, $registros";
	$consulta_total = "SELECT COUNT(*) FROM novedades WHERE DATE('$hoy') BETWEEN fechaDesdeNovedad AND fechaHastaNovedad ";

	$datos = mysqli_query($conexion, $consulta_datos);

	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
	$Npaginas = ceil($total_registros / $registros);
	
	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){ 
			$codNovedad = $rows['codNovedad'];						
			$tabla.=' 
				<div class="locales">
						<div class="textContainer">

								<h1>	'. htmlspecialchars($rows['textoNovedad']) . '</h1>
							<h4> Fecha desde novedad: </h4>
								<p> '. htmlspecialchars($rows['fechaDesdeNovedad']) .  '</p>
							<h4> Fecha hasta novedad: </h4>
								<p>	'. htmlspecialchars($rows['fechaHastaNovedad']) . ' </p>
							<h4> Tipo de cliente novedad: </h4>
								<p>	'. htmlspecialchars($rows['tipoUsuario']) .  '</p>
						</div>';
			if(!isset($_SESSION['tipoCliente']) || (isset($_SESSION['tipoCliente']) && $_SESSION['tipoUsuario'] == "Administrador"))  {
                $tabla.='<div class="textContainer">
							<form action="index.php?vista=novedadesUpdate" method="POST">
								<input type="hidden" name="codNovedad" value="'.htmlspecialchars($codNovedad) .'">
								<input type="submit" name="botonAnashe" class="btn btn-warning" value="Modificar Novedad">
							</form>
							<br>
							<br>
							<form action="./php/admin/eliminarNovedades.php" method="POST">
								<input type="hidden" name="codNovedad" value="'.htmlspecialchars($codNovedad) .'">
								<input type="hidden" name="dato" value="valor">
								<button type="submit"  name="botonAnashe" value="Eliminar Novedad" class="btn btn-danger" onclick="return confirmar();">Eliminar Novedad</button>
							
							</form>
                        </div>';
					}
            $tabla.= '</div>';
            
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
						<p class="centered" style="color: red">	No hay novedades disponibles </p>
					</td>
				</tr>
			';
		}
	}


	$tabla.='</tbody></table>';

	if($total_registros>0 && $pagina<=$Npaginas){
		$tabla.='<p style="text-align: center; color: white;">
    		Mostrando locales <strong>'. $pag_inicio .'</strong> al 
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
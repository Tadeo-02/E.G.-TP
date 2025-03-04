<?php
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	
	//? FECHA HOY
	$hoy = date("Y-m-d");

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	
	$tabla="";

	$codUsuario = $_SESSION['codUsuario'] ?? null; // Evita error si no está definido
	
	$consulta_total = "SELECT * FROM usuarios WHERE estadoCuenta = 'Pendiente'";

	$datos = mysqli_query($conexion, $consulta_total);

	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
	$Npaginas = ceil($total_registros / $registros);
	
	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){ 
			$codUsuario = $rows['codUsuario'];						
			$tabla.=' 
				<div class="locales">
						<div class="textContainer">

								<h1>	'. htmlspecialchars($rows['nombreUsuario']) . '</h1>
						</div>';
                $tabla.='<div class="textContainer">
							<form action="./php/admin/aprobarSolicitudCuenta.php" method="POST">
								<input type="hidden" name="codUsuario" value="'.htmlspecialchars($codUsuario) .'">
								<input type="submit" name="botonAnashe" class="btn btn-success" value="Aceptar Solicitud">
							</form>
							<br>
							<br>
							<form action="./php/admin/denegarSolicitudCuenta.php" method="POST">
								<input type="hidden" name="codUsuario" value="'.htmlspecialchars($codUsuario) .'">
								<input type="hidden" name="dato" value="valor">
								<button type="submit"  name="botonAnashe" value="Denegar Solicitud" class="btn btn-danger" onclick="return confirmar();">Denegar Solicitud</button>
							
							</form>
                        </div>';
					
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
						<p class="centered" style="color: red">	No hay solicitudes de cuenta de dueño disponibles </p>
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
    return confirm("¿Seguro que quieres rechazar esta solicitud?");
}
</script>





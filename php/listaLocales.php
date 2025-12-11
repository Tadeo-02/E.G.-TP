<?php
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

	$tabla='';

	$tipoUsuario = isset($_SESSION['tipoUsuario']) ? $_SESSION['tipoUsuario'] : '';
	$codDueño = isset($_SESSION['codUsuario']) ? $_SESSION['codUsuario'] : '';
	
	// Definimos los datos a consultar
	$condiciones = [];
	if ($tipoUsuario == "Dueño") {
		$condiciones[] = "codUsuario = '$codDueño'";
	}
	if (!empty($busqueda)) {
		$condiciones[] = "nombreLocal LIKE '%$busqueda%'";
	}
	if (!empty($rubroLocal)) {
		$condiciones[] = "rubroLocal = '$rubroLocal'";
	}

	$where = count($condiciones) > 0 ? 'WHERE ' . implode(' AND ', $condiciones) : '';

	$consulta_datos = "SELECT * FROM locales $where ORDER BY $ordenar ASC LIMIT $inicio, $registros";
	$consulta_total = "SELECT COUNT(*) FROM locales $where";

	$datos = mysqli_query($conexion, $consulta_datos);

	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
	$Npaginas = ceil($total_registros / $registros);

	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){ 
			$nombreLocal = $rows['nombreLocal'];
			$codLocal = $rows['codLocal']; //Para mostrar la imagen usamos la etiqueta img con la ruta src donde almacenamos las imagenes + nombre de la imagen que se guarda en la DB
		
		// Verificar si hay imagen, sino usar una por defecto
		$imagenLocal = !empty($rows['imagenLocal']) ? htmlspecialchars($rows['imagenLocal']) : 'imagenLocal.jpeg';
		
		$tabla.=' 
			<div class="col-12 col-md-6 mb-2 mb-md-4">
				<div class="locales">
					<div class="imgContainer-local">
						<img src="/php/admin/locales/' . $imagenLocal . '" 
             					alt="Imagen de ' . htmlspecialchars($rows['nombreLocal']) . '">
					</div>
					<div class="textContainer-local">
						<h2>'. htmlspecialchars($rows['nombreLocal']) . '</h2>
						<div class="local-info">
							<p><strong>📍 Ubicación:</strong> '. htmlspecialchars($rows['ubicacionLocal']) .  '</p>
							<p><strong>🏷️ Rubro:</strong> '. htmlspecialchars($rows['rubroLocal']) . '</p>
						</div>
						<div class="local-meta">
							<span class="local-id">ID: '. htmlspecialchars($rows['codLocal']) .'</span>
						</div>
					</div>';
			if(!isset($_SESSION['tipoUsuario']) || (isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario'] == "Cliente"))  {
				$tabla.= '<div class="textContainer-local-buttons">
							<form action="index.php" method="GET">
								<input type="hidden" name="vista" value="promocionesList">
								<input type="hidden" name="codLocal" value="'.htmlspecialchars($codLocal) .'">
								<button type="submit" id="botonAnashe" class="btn btn-primary">Ver Promociones</button>
							</form>
                		</div>
					</div>
				</div>';
			}
			else {
				$tabla.='<div class="textContainer-local-buttons">
							<form action="index.php?vista=localsUpdate" method="POST">
								<input type="hidden" name="nombreLocal" value="'. htmlspecialchars($nombreLocal) .'">
								<input type="hidden" name="codLocal" value="'. htmlspecialchars($codLocal) .'">
								<input type="submit" name="botonAnashe" class="btn btn-warning" value="Modificar Local">
							</form>
							<form action="./php/admin/eliminarLocales.php" method="POST">
								<input type="hidden" name="codLocal" value="'.htmlspecialchars($codLocal) .'">
								<input type="hidden" name="dato" value="valor">
								<button type="submit"  name="botonAnashe" value="Eliminar Local" class="btn btn-danger" onclick="return confirmar();">Eliminar Local</button>
							</form>
						</div>
					</div>
				</div>';
			}

            $contador++;
		}
		$pag_final=$contador-1;

	// Si no hay registros, mostrar un mensaje
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
						<p class="centered" style="color: red">	No hay locales disponibles </p>
					</td>
				</tr>
			';
		}
	}

	$tabla.='</tbody></table>';

	//Paginador
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
    return confirm("¿Seguro que quieres eliminar este Local?");
}
</script>
<?php
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

	$tabla="";

	if (isset($busqueda) && $busqueda != "") {
		if($rubroLocal != ""){
			$consulta_datos="SELECT * FROM locales  WHERE rubroLocal = '$rubroLocal' AND nombreLocal LIKE '%$busqueda%' ORDER BY nombreLocal ASC LIMIT $inicio,$registros";
			$consulta_total="SELECT COUNT(*) FROM locales WHERE rubroLocal = '$rubroLocal' AND nombreLocal LIKE '%$busqueda%'";
		}else {	
			$consulta_datos = "SELECT * FROM locales WHERE nombreLocal LIKE '%$busqueda%' ORDER BY nombreLocal LIMIT $inicio, $registros";
			$consulta_total = "SELECT COUNT(*) FROM locales WHERE nombreLocal LIKE '%$busqueda%'";
		}

	}else {
		if($rubroLocal != ""){
			$consulta_datos="SELECT * FROM locales  WHERE rubroLocal = '$rubroLocal' ORDER BY nombreLocal ASC LIMIT $inicio,$registros";
			$consulta_total="SELECT COUNT(*) FROM locales WHERE rubroLocal = '$rubroLocal'";
		}else {	
			$consulta_datos = "SELECT * FROM locales ORDER BY nombreLocal LIMIT $inicio, $registros";
			$consulta_total = "SELECT COUNT(*) FROM locales";
		}
	}

	$datos = mysqli_query($conexion, $consulta_datos);

	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
	$Npaginas = ceil($total_registros / $registros);

	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){ 
			$nombreLocal = $rows['nombreLocal'];
			$codLocal = $rows['codLocal']; //Para mostrar la imagen usamos la etiqueta img con la ruta src donde almacenamos las imagenes + nombre de la imagen que se guarda en la DB
			$tabla.=' 
				<div class="locales col-12 col-md-4">
						<div class="imgContainer">
							<img src="/TP ENTORNOS/php/admin/locales/' . htmlspecialchars($rows['imagenLocal']) . '" 
             				alt="Imagen de ' . htmlspecialchars($rows['nombreLocal']) . '">
						</div>
						<div class="textContainer">
								<h1>	'. htmlspecialchars($rows['nombreLocal']) . '</h1>
							<h4> Ubicacion del Local: </h4>
								<p> '. htmlspecialchars($rows['ubicacionLocal']) .  '</p>
							<h4> Rubro del Local: </h4>
								<p>	'. htmlspecialchars($rows['rubroLocal']) . ' </p>
							<h4> Código del Local: </h4>
								<p>	'. htmlspecialchars($rows['codLocal']) .  '</p>
						</div>';
			if(!isset($_SESSION['tipoUsuario']) || (isset($_SESSION['tipoUsuario']) && $_SESSION['tipoUsuario'] == "Cliente"))  {
				$tabla.= '<div class="textContainer col-12 col-md-4">
							<form action="index.php" method="GET">
								<input type="hidden" name="vista" value="promocionesList">
								<input type="hidden" name="codLocal" value="'.htmlspecialchars($codLocal) .'">
								<input type="submit" name="botonAnashe" class="btn-primary" value="Ver Promociones">
							</form>
                		</div>
					</div>';
			}
			elseif ($_SESSION['tipoUsuario'] == "Administrador"){
				$tabla.='<div class="textContainer col-12 col-md-4">
							<form action="index.php?vista=localsUpdate" method="POST">
								<input type="hidden" name="nombreLocal" value="'. htmlspecialchars($nombreLocal) .'">
								<input type="hidden" name="codLocal" value="'. htmlspecialchars($codLocal) .'">
								<input type="submit" name="botonAnashe" class="btn btn-warning" value="Modificar Local">
							</form>
							<br>
							<br>
							<form action="./php/admin/eliminarLocales.php" method="POST">
								<input type="hidden" name="codLocal" value="'.htmlspecialchars($codLocal) .'">
								<input type="hidden" name="dato" value="valor">
								<button type="submit"  name="botonAnashe" value="Eliminar Local" class="btn btn-danger" onclick="return confirmar();">Eliminar Local</button>
							</form>
                        </div>
					</div>';
			}
			else {
				$tabla.='<div class="textContainer ">
							<form action="index.php?vista=localsUpdate" method="POST">
								<input type="hidden" name="nombreLocal" value="'. htmlspecialchars($nombreLocal) .'">
								<input type="hidden" name="codLocal" value="'. htmlspecialchars($codLocal) .'">
								<input type="submit" name="botonAnashe" class="btn btn-warning" value="Modificar Local">
							</form>
							<br>
							<br>
							<form action="./php/admin/eliminarLocales.php" method="POST">
								<input type="hidden" name="codLocal" value="'.htmlspecialchars($codLocal) .'">
								<input type="hidden" name="dato" value="valor">
								<button type="submit"  name="botonAnashe" value="Eliminar Local" class="btn btn-danger" onclick="return confirmar();">Eliminar Local</button>
							</form>
						</div>
					</div>';
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
				<tr class="has-text-centered" >
					<td>
						<p class="centered" style="color: red">	No hay locales disponibles </p>
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
    return confirm("¿Seguro que quieres eliminar este Local?");
}
</script>
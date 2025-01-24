<?php
	require_once(__DIR__ . '/../inc/head.php');
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$tabla="";

	if (isset($busqueda) && $busqueda != "") {
		$consulta_datos = "SELECT * FROM locales WHERE (rubroLocal LIKE '%$busqueda%') ORDER BY nombreLocal LIMIT $inicio, $registros";
		$consulta_total = "SELECT COUNT(*) FROM locales WHERE (rubroLocal LIKE '%$busqueda%')";
	} else {
		$consulta_datos = "SELECT * FROM locales ORDER BY nombreLocal LIMIT $inicio, $registros";
		$consulta_total = "SELECT COUNT(*) FROM locales";
	}

	$datos = mysqli_query($conexion, $consulta_datos);

	// $datos = $datos->fetch_all();

	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
	$Npaginas = ceil($total_registros / $registros);

	// $total = $conexion->query($consulta_total);
	// $total = (int) $total->fetch_column();

	// $Npaginas =ceil($total/$registros);

	$tabla.='
	<div class="container-fluid">
    <table class="table table-bordered table-striped table-hover text-center">
        <thead class="table-dark">
                <tr class="has-text-centered">
                	<th>#</th>
                    <th>Nombre de Local</th>
                    <th>Ubicacion del Local</th>
                    <th>Rubro del Local</th>
                    <th>Imagen del local</th>
                </tr>
            </thead>
            <tbody>
	';

	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		// $pag_inicio=$inicio+1;
		foreach($datos as $rows){
			$tabla.='
				<tr>
					<td>'.$contador.'</td>
					<td>' . htmlspecialchars($rows['nombreLocal']) . '</td>
					<td>' . htmlspecialchars($rows['ubicacionLocal']) . '</td>
					<td>' . htmlspecialchars($rows['rubroLocal']) . '</td>
                </tr>
            ';
// <td>
//     <a href="index.php?vista=user_update&user_id_up='.$rows['codLocal'].'" class="btn btn-success btn-sm rounded-pill">Actualizar</a>
// </td>
// <td>
//     <a href="'.$url.$pagina.'&user_id_del='.$rows['codLocal'].'" class="btn btn-danger btn-sm rounded-pill">Eliminar</a>
// </td>

            $contador++;
		}
		// $pag_final=$contador-1;
	}else{
		if($total_registros>=1){
			$tabla.='
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
					<td colspan="4">
						No hay registros en el sistema
					</td>
				</tr>
			';
		}
	}


	$tabla.='</tbody></table></div>';

	// if($total_registros>0 && $pagina<=$Npaginas){
	// 	$tabla.='<p class="has-text-right">Mostrando locales <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total_registros.'</strong></p>';
	// }

	mysqli_close($conexion);

	echo $tabla;

	if($total_registros>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}
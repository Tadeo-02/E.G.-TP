<?php
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$tabla="";

	if(isset($busqueda) && $busqueda!=""){

		$consulta_datos="SELECT * FROM locales WHERE (rubroLocal LIKE '%$busqueda%') ORDER BY nombreLocal ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(codLocal) FROM locales WHERE (rubroLocal LIKE '%$busqueda%' )";

	}else{

		$consulta_datos="SELECT * FROM locales ORDER BY nombreLocal ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(codLocal) FROM locales";
	}

	$conexion=conexion();

	$datos = $conexion->query($consulta_datos);
	$datos = $datos->fetch_all();

	$total = $conexion->query($consulta_total);
	$total = (int) $total->fetch_column();

	$Npaginas =ceil($total/$registros);

	$tabla.='
	<div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                	<th>#</th>
                    <th>Nombre de Local</th>
                    <th>Ubicacion del Local</th>
                    <th>Rubro del Local</th>
                    <th>Imagen del local ??? </th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
	';

	if($total>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){
			$tabla.='
				<tr class="has-text-centered" >
					<td>'.$contador.'</td>
                    <td>'.$rows['nombreLocal'].'</td>
                    <td>'.$rows['ubicacionLocal'].'</td>
                    <td>'.$rows['rubroLocal	'].'</td>
                    <td>
                        <a href="index.php?vista=user_update&user_id_up='.$rows['codLocal'].'" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&user_id_del='.$rows['codLocal'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
		}
		$pag_final=$contador-1;
	}else{
		if($total>=1){
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="7">
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para recargar el listado
						</a>
					</td>
				</tr>
			';
		}else{
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="7">
						No hay registros en el sistema
					</td>
				</tr>
			';
		}
	}


	$tabla.='</tbody></table></div>';

	if($total>0 && $pagina<=$Npaginas){
		$tabla.='<p class="has-text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;

	if($total>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}
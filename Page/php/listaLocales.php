<?php
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;

	$tabla="";

	if (isset($busqueda) && $busqueda != "") {
		if($rubroLocal != ""){
			$consulta_datos="SELECT * FROM locales  WHERE rubroLocal = '$rubroLocal' AND (nombreLocal LIKE '%$busqueda%' OR rubroLocal LIKE '%$busqueda%') ORDER BY nombreLocal ASC LIMIT $inicio,$registros";
			$consulta_total="SELECT COUNT(*) FROM locales WHERE rubroLocal = '$rubroLocal' AND (nombreLocal LIKE '%$busqueda%' OR rubroLocal LIKE '%$busqueda%')";
		}else {	
			$consulta_datos = "SELECT * FROM locales WHERE (nombreLocal LIKE '%$busqueda%' OR rubroLocal LIKE '%$busqueda%') ORDER BY nombreLocal LIMIT $inicio, $registros";
			$consulta_total = "SELECT COUNT(*) FROM locales WHERE (nombreLocal LIKE '%$busqueda%' OR rubroLocal LIKE '%$busqueda%')";
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

	// $datos = $datos->fetch_all();

	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
	$Npaginas = ceil($total_registros / $registros);

	

	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		// $pag_inicio=$inicio+1;
		foreach($datos as $rows){ 						//<td>'.$contador.'</td>
			$tabla.='
				<div class="locales">
						<div class="imgContainer">
             				<img src="https://i.pinimg.com/736x/44/6e/0e/446e0e3dda539cc4cee175695364bba9.jpg" alt="huevardo">
         				</div>
						<div class="textContainer">

								<h1>	'. htmlspecialchars($rows['nombreLocal']) . '</h1>
							<h3> Ubicacion del Local: </h3>
								<p> '. htmlspecialchars($rows['ubicacionLocal']) .  '</p>
							<h3> Rubro del Local: </h3>
								<p>	'. htmlspecialchars($rows['rubroLocal']) . ' </p>
							<h3> Código del Local: </h3>
								<p>	'. htmlspecialchars($rows['codLocal']) .  '</p>
						</div>
						<div class="containerButton">
						    <input type="submit" name="botonAnashe" id="" class="btn-primary" value="Ver Promociones">
						</div>
                </div>
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
					<td colspan="4">
						No hay registros en el sistema
					</td>
				</tr>
			';
		}
	}


	$tabla.='</tbody></table>';

	// if($total_registros>0 && $pagina<=$Npaginas){
	// 	$tabla.='<p class="has-text-right">Mostrando locales <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total_registros.'</strong></p>';
	// }

	mysqli_close($conexion);

	echo $tabla;

	if($total_registros>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}




// 	  HTML LOCALES

// <div class="container">
//         <div class="imgContainer">
//             <img src="https://i.pinimg.com/736x/44/6e/0e/446e0e3dda539cc4cee175695364bba9.jpg" alt="huevardo">
//         </div>
//         <div class="textContainer">
//             <h2>
//                 Código del Local:
//             </h2>
//             <br>
//             <h2>
//                 Nombre del Local:
//             </h2>
//             <br>
//             <h2>
//                 Ubicación del Local:
//             </h2>
//             <br>
//             <h2>
//                 Rubro:
//             </h2>
//         </div>
//         <div class="containerButton">
//             <input type="submit" name="botonAnashe" id="" class="btn-primary">
//         </div>
//     </div> -->

//      CSS LOCALES 



// $total = $conexion->query($consulta_total);
	// $total = (int) $total->fetch_column();

	// $Npaginas =ceil($total/$registros);

	// $tabla.='
	// <div class="container-fluid">
    // <table class="table table-bordered table-striped table-hover text-center">
    //     <thead class="table-dark">
    //             <tr class="has-text-centered">
    //             	<th>#</th>
    //                 <th>Nombre de Local</th>
    //                 <th>Ubicacion del Local</th>
    //                 <th>Rubro del Local</th>
    //                 <th>Imagen del local</th>
    //             </tr>
    //         </thead>
    //         <tbody>';


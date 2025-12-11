<?php
	$conexion=conexion();

	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	
	$tabla="";
	$codDueño = isset($_SESSION['codUsuario']) ? $_SESSION['codUsuario'] : '';
	$tipoUsuario = isset($_SESSION['tipoUsuario']) ? $_SESSION['tipoUsuario'] : '';
	//Armar consulta
	$campos="uso_promociones.codUsoPromociones, uso_promociones.codCliente, uso_promociones.codPromo, uso_promociones.fechaUsoPromo, uso_promociones.estado, promociones.codLocal, promociones.codPromo, promociones.textoPromo, promociones.categoriaCliente, promociones.fechaDesdePromo, promociones.fechaHastaPromo, promociones.diasSemana, locales.codLocal, locales.codUsuario, locales.nombreLocal";

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
						ORDER BY $ordenar ASC 
						LIMIT $inicio, $registros";

	$consulta_total = "SELECT COUNT(DISTINCT promociones.codPromo) FROM promociones 
						$innerjoin 
						$where";
                        
	$datos = mysqli_query($conexion, $consulta_datos);
	$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];
	$Npaginas = ceil($total_registros / $registros);
	//Mostrar Reporte
	if($total_registros>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		$tabla =' <div class="wrapper">
					<table class="reporte">
						<tr class="reporteRow">
							<th class="reporteHeading">
								<a class="linkTabla" href="index.php?vista=discountReport&sortBy=uso_promociones.fechaUsoPromo">Fecha Uso ↓</a>
							</th>
							<th class="reporteHeading">
								<a class="linkTabla" href="index.php?vista=discountReport&sortBy=uso_promociones.codPromo">Código Promoción ↓</a>
							</th>
							<th class="reporteHeading">
								<a class="linkTabla" href="index.php?vista=discountReport&sortBy=promociones.textoPromo">Promoción ↓</a>
							</th>
							<th class="reporteHeading">
								<a class="linkTabla" href="index.php?vista=discountReport&sortBy=locales.codLocal">Código Local ↓</a>
							</th>
							<th class="reporteHeading">
								<a class="linkTabla" href="index.php?vista=discountReport&sortBy=locales.nombreLocal">Local ↓</a>
							</th>
							<th class="reporteHeading">
								Usos
							</th>
						</tr>
		';
		foreach($datos as $rows){ 
			$codCliente = $rows['codCliente'];
			$codPromo = $rows['codPromo'];
            $consulta_contador = "SELECT COUNT(*) FROM uso_promociones WHERE estado = 'Aprobada' AND  codPromo = $codPromo";
            $datosContador = mysqli_query($conexion, $consulta_contador);
            $fila = mysqli_fetch_row($datosContador);
			$tabla.='<tr class="reporteRow">
						<td data-cell="fecha uso" class="reporteContent">'.$rows['fechaUsoPromo'].'</td>
						<td data-cell="Código Promo" class="reporteContent">'.$rows['codPromo'].'</td>
						<td data-cell="Promoción" class="reporteContent">'.$rows['textoPromo'].'</td>
						<td data-cell="Código Local" class="reporteContent">'.$rows['codLocal'].'</td>
						<td data-cell="Local" class="reporteContent">'.$rows['nombreLocal'].'</td>
						<td data-cell="Usos" class="reporteContent">'.$fila[0].'</td>
					</tr>';
            
            $contador++;
		}
		$pag_final=$contador-1;
	}else{
		// Si no hay registros, mostrar un mensaje
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
	//Paginador
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

	// Define una función para hacer las celdas de las tablas responsivas añadiendo los encabezados como pseudo-elementos
	function ResponsiveCellHeaders(elmID) {
	try {
		// Crea un arreglo para almacenar el texto de todos los encabezados de la tabla
		var THarray = [];
		// Obtiene el elemento de la tabla por su ID
		var table = document.getElementById(elmID);
		// Obtiene todos los elementos <th> (encabezados de tabla) dentro de la tabla
		var ths = table.getElementsByTagName("th");
		
		// Recorre todos los encabezados y almacena su contenido de texto en el arreglo
		for (var i = 0; i < ths.length; i++) {
		var headingText = ths[i].innerHTML;
		THarray.push(headingText);
		}
		
		// Crea un elemento <style> para agregar reglas CSS dinámicamente
		var styleElm = document.createElement("style"),
			styleSheet;
		// Agrega el elemento <style> al encabezado del documento
		document.head.appendChild(styleElm);
		styleSheet = styleElm.sheet;

		// Recorre el arreglo de encabezados y crea reglas CSS
		for (var i = 0; i < THarray.length; i++) {
		styleSheet.insertRule(
			"#" +
			elmID +
			" td:nth-child(" +
			(i + 1) +
			')::before {content:"' +
			THarray[i] +
			': ";}', // Agrega el texto del encabezado como un pseudo-elemento antes de cada celda
			styleSheet.cssRules.length
		);
		}
	} catch (e) {
		// Registra cualquier error en la consola
		console.log("ResponsiveCellHeaders(): " + e);
	}
	}

	// Llama a la función ResponsiveCellHeaders para una tabla con el ID "Books"
	ResponsiveCellHeaders("Books");

	// Función para agregar roles ARIA a tablas, filas, celdas y encabezados para mejorar la accesibilidad
	function AddTableARIA() {
	try {
		// Obtiene todos los elementos de tabla en el documento
		var allTables = document.querySelectorAll('table');
		// Agrega el rol "table" a todos los elementos de tabla
		for (var i = 0; i < allTables.length; i++) {
		allTables[i].setAttribute('role','table');
		}

		// Obtiene todos los grupos de filas (<thead>, <tbody>, <tfoot>)
		var allRowGroups = document.querySelectorAll('thead, tbody, tfoot');
		// Agrega el rol "rowgroup" a estos elementos
		for (var i = 0; i < allRowGroups.length; i++) {
		allRowGroups[i].setAttribute('role','rowgroup');
		}

		// Obtiene todas las filas de la tabla (<tr>)
		var allRows = document.querySelectorAll('tr');
		// Agrega el rol "row" a cada fila de la tabla
		for (var i = 0; i < allRows.length; i++) {
		allRows[i].setAttribute('role','row');
		}

		// Obtiene todas las celdas de la tabla (<td>)
		var allCells = document.querySelectorAll('td');
		// Agrega el rol "cell" a cada celda de la tabla
		for (var i = 0; i < allCells.length; i++) {
		allCells[i].setAttribute('role','cell');
		}

		// Obtiene todos los encabezados de la tabla (<th>)
		var allHeaders = document.querySelectorAll('th');
		// Agrega el rol "columnheader" a cada encabezado de columna
		for (var i = 0; i < allHeaders.length; i++) {
		allHeaders[i].setAttribute('role','columnheader');
		}

		// Maneja específicamente los encabezados de filas (<th> con scope="row")
		var allRowHeaders = document.querySelectorAll('th[scope=row]');
		// Agrega el rol "rowheader" a estos elementos
		for (var i = 0; i < allRowHeaders.length; i++) {
		allRowHeaders[i].setAttribute('role','rowheader');
		}

		// Nota: No se agrega el rol de caption ya que no es un rol ARIA reconocido
	} catch (e) {
		// Registra cualquier error en la consola
		console.log("AddTableARIA(): " + e);
	}
	}

	// Llama a la función AddTableARIA para aplicar roles ARIA a todas las tablas en el documento
	AddTableARIA();

</script>




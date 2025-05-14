<?php
$conexion = conexion();

$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

$hoy = date("Y-m-d");

$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

$tabla = "";

$codUsuario = $_SESSION['codUsuario'] ?? null; // Evita error si no está definido

$consulta_datos = "SELECT * FROM usuarios WHERE estadoCuenta = 'Pendiente'";
$consulta_total = "SELECT COUNT(*) FROM usuarios WHERE estadoCuenta = 'Pendiente'";

$datos = mysqli_query($conexion, $consulta_datos);
$total_registros = mysqli_fetch_array(mysqli_query($conexion, $consulta_total))[0];

$Npaginas = ceil($total_registros / $registros);

if ($total_registros >= 1 && $pagina <= $Npaginas) {
	$contador = $inicio + 1;
	$pag_inicio = $inicio + 1;
	foreach ($datos as $rows) {
		$codUsuario = $rows['codUsuario'];
		$nombreUsuario = $rows['nombreUsuario'];
		$tabla .= '<div class="wrapper">
					<table class="reporte">
						<tr class="reporteRow">
							<th class="reporteHeading">
								Cuenta
							</th>
							<th class="reporteHeading"></th>
						</tr>
						<tr class="reporteRow">
							<td data-cell="Cuenta" class="reporteContent">' . htmlspecialchars($nombreUsuario) . '</td>
							<td data-cell="Aceptar/Rechazar" class="botonesTD reporteContent" style="width: 25%;">
								<div class="formContainerSolicitud">
									<form action="./php/admin/aprobarSolicitudCuenta.php" method="POST">
										<input type="hidden" name="codUsuario" value="' . htmlspecialchars($codUsuario) . '">
										<input type="hidden" name="email" value="' . htmlspecialchars($nombreUsuario) . '"> <br>
										<input type="hidden" name="asunto" value="Solicitud cuenta de due&ntilde;o"> <br>
										<input type="hidden" name="mensaje" value="Su solicitud de cuenta ha sido ACEPTADA."> <br>
										<button type="submit" name="botonAnashe" class="btn btn-success btnTabla" value="Aceptar Solicitud" onclick="return confirmar();">Aceptar Solicitud</button>
									</form>
									<form action="./php/admin/denegarSolicitudCuenta.php" method="POST">
										<input type="hidden" name="codUsuario" value="' . htmlspecialchars($codUsuario) . '">
										<input type="hidden" name="email" value="' . htmlspecialchars($nombreUsuario) . '"> <br>
										<input type="hidden" name="asunto" value="Solicitud cuenta de due&ntilde;o"> <br>
										<input type="hidden" name="mensaje" value="Su solicitud de cuenta ha sido RECHAZADA."> <br>
										<button type="submit" name="botonAnashe" value="Denegar Solicitud" class="btn btn-danger btnTabla" onclick="return rechazar();">Denegar Solicitud</button>
									</form>
								</div>
							</td>
						</tr>
					</table>
				</div>';

		$contador++;
	}
	$pag_final = $contador - 1;
} else {
	// Si no hay registros, mostrar un mensaje
	if ($total_registros >= 1) {
		$tabla .= ' <table>
				<tr class="has-text-centered" >
					<td>
						<a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4		Haga clic acá para recargar el listado
                    </
				</tr>
			';
	} else {
		$tabla .= '
				<tr class="has-text-centered" >
					<td>
						<p class="centered" style="color: red">	No hay solicitudes de cuenta de dueño pendientes </p>
					</td>
				</tr>
			';
	}
}

$tabla .= '</tbody></table>';
//Paginador
if ($total_registros > 0 && $pagina <= $Npaginas) {
	$tabla .= '<p style="text-align: center; color: white;">
    		Mostrando Solicitudes de Cuenta de dueño <strong>' . $pag_inicio . '</strong> al 
    		<strong>' . $pag_final . '</strong> de un 
    		<strong>total de ' . $total_registros . '</strong>
		</p>';
}

mysqli_close($conexion);

echo $tabla;

if ($total_registros >= 1 && $pagina <= $Npaginas) {
	echo paginador_tablas($pagina, $Npaginas, $url, 7);
}
?>

<script>
	function confirmar() {
		return confirm("¿Seguro que quieres aceptar esta solicitud?");
	}

	function rechazar() {
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



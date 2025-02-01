<?php
	session_unset();  // Eliminar todas las variables de sesión
	session_destroy(); // Destruir la sesión
	
	// Evitar que el navegador almacene en caché la sesión cerrada
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Expires: 0");
	
	if(headers_sent()){ //encabezados
		echo "<script> window.location.href='index.php?vista=login' </script>";
	}else{
		header("Location: index.php?vista=login");
	}
?>
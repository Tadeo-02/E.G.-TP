<?php
	session_destroy();

	if(headers_sent()){ //encabezados
		echo "<script> window.location.href='/TP ENTORNOS/Page/vistas/login.php'; </script>";
	}else{
		header("Location: index.php?vista=login");
	}
?>
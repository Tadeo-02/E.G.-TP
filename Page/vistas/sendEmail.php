
<section id="about" class="about">
	<div class="container-fluid">
    
	<!-- SE MUESTRA EL RESULTADO DEL FORM CON ESTE DIV "form-rest" -->
        <div class="form-rest"></div>
        <?php
            require_once(__DIR__ . '/../php/main.php');
        ?>
            <div class="row cargaPromociones">
                <div class="col-12">
                    <h1>CARGA DE PROMOCIONES</h1>
                    <br>
<head>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        select[multiple] {
            height: auto;
        }
    </style>
</head>

                    <div class="container">
                        <div class="form-container">
                            <h3 class="text-center mb-4">Solcitud de Promoción</h3>
                            

<form class ="" action="/TP ENTORNOS/Page/php/admin/enviarMail.php" method="POST" autocomplete="off">
Email <input type="email" name="email" value=""> <br>
Asunto <input type="text" name="asunto" value=""> <br>
Mensaje <input type="text" name="mensaje" value=""> <br>
<button type="submit" name="send" value="">ENVIAR </button> <br>




</form>

                        </div>
                    </div>
                
                </div>
            </div>
	</div>		

</section>
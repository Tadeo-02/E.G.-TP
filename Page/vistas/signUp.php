<div class="container is-fluid mb-6">
	<h1 class="title">Usuarios</h1>
	<h2 class="subtitle">Nuevo usuario</h2>
</div>
<div class="container pb-6 pt-6">
    
<!-- SE MUESTRA EL RESULTADO DEL FORM CON ESTE DIV "form-rest" -->
	<div class="form-rest mb-6 mt-6"></div>

	<form action="/TP ENTORNOS/Page/php/saveUser.php" method="POST" class="FormularioAjax" autocomplete="off" >
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Email</label>
				  	<input class="input" type="email" name="nombreUsuario" maxlength="70" required>
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Clave</label>
				  	<input class="input" type="password" name="claveUsuario1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Repetir clave</label>
				  	<input class="input" type="password" name="claveUsuario2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
				</div>
		  	</div>
		</div>
		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>
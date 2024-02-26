<?php require_once("controlador/cini.php"); ?>

<div class="inicio">
	<h2>Inicio de Sesión</h2>
		<?php erroraute(); ?>
	<form name="frm1" action="modelo/control.php" method="POST">
		<label>Usuario</label>
		<input type="text" name="usu" class="form-control" required>

		<label>Contraseña</label>
		<input type="password" name="con" class="form-control" required>

		<div class="cen">
			<input type="submit" class="btn btn-secondary" value="Ingresar">
		</div>
	</form>
	<div class="cen">
		<a href="index.php?pg=100">
			<button type="button" class="btn btn-outline-secondary">Registrese Aquí</button>
		</a>
	</div>
	<div class="cen">
		<a href="index.php?pg=105">
			<button type="button" class="btn btn-outline-secondary">		¿Olvido su contraseña?</button>
		</a>
	</div>
</div>
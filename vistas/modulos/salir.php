<?php
ModeloUsuarios::mdlActualizarUsuario("usuarios","iniciada",0,"id",$_SESSION["id"]);
session_destroy();
echo '<script>
		localStorage.clear();
		window.location="ingreso";
	</script>';
<?php
	session_unset();
	session_destroy();
	echo '<script>
			localStorage.clear();
			window.location="ingreso";
		</script>';
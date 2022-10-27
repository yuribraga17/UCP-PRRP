<?php	
session_destroy();

unset ($_SESSION['usuarioID']);
unset ($_SESSION['nomeUsuario']);

die('<script type="text/javascript">window.location.href="login";</script>');
?>
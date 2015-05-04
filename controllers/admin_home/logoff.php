<?php
unset($_SESSION['grc.userId']);
unset($_SESSION['grc.userNome']);
unset($_SESSION['grc.userEmail']);
unset($_SESSION['grc.userPerfil']);
unset($_SESSION['grc.userAcesso']);
session_destroy();
header("Location:index.php");
exit();

?>

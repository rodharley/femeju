<?php
unset($_SESSION['fmj.userId']);
unset($_SESSION['fmj.userNome']);
unset($_SESSION['fmj.userEmail']);
unset($_SESSION['fmj.userPerfil']);
unset($_SESSION['fmj.userAcesso']);
session_destroy();
header("Location:admin_home-index");
exit();

?>

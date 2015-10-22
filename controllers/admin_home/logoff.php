<?php
unset($_SESSION['fmj.userId']);
unset($_SESSION['fmj.userNome']);
unset($_SESSION['fmj.userPerfil']);
unset($_SESSION['fmj.userFoto']);
unset($_SESSION['fmj.userPerfilId']);
unset($_SESSION['fmj.userPerfil']);
unset($_SESSION['fmj.menu']);
unset($_SESSION['start']);
        unset($_SESSION['expire']);
session_destroy();
header("Location:admin_home-index");
exit();

?>
